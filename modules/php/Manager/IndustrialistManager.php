<?php
namespace Bga\Games\tycoonindianew\Manager;

use Bga\GameFramework\Components\Counters\PlayerCounter;

use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\Model\Industrialist;

use Bga\Games\tycoonindianew\Query\SelectDBQuery;
use Bga\Games\tycoonindianew\Query\DBQueryResult;

use Bga\Games\tycoonindianew\Registry\FilterRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\OperatorType;
use Bga\Games\tycoonindianew\Type\OrderByDirection;
use Bga\Games\tycoonindianew\Type\QueryStatus;
use Bga\Games\tycoonindianew\Util\DataUtil;

class IndustrialistManager implements Manager {

  /**
   * Array of industrialists by their player id
   * @var array
   */
  protected static $industrialists = [];

  /**
   * Array of all player counters
   * @var array
   */
  protected static $counters = [];

  /**
   * Singleton instance of the Industrialist manager
   * @var IndustrialistManager|null
   */
  private static ?IndustrialistManager $instance = null;

  private function __construct() {
    // Empty private constructor for singleton instance creation
  }

  /**
   * Get (or create and get) singleton instance of Industrialist Manager
   * @return IndustrialistManager
   */
  public static function instance(): IndustrialistManager {
    if (self::$instance == null) {
      self::$instance = new IndustrialistManager();
    }

    return self::$instance;
  }

  /*********************************************************************************************/
  /***************************************NEW GAME SETUP****************************************/
  /*********************************************************************************************/
  
  /**
   * Setup industrialists at the start of a new game for given players
   * @param array $players
   * @return void
   */
  public function setupNewGame($players) {
    foreach ($players as $playerId => $player) {
      $game = Game::get();

      $player_no = intval($game->getPlayerNoById($playerId));
      $player_name = strval($game->getPlayerNameById($playerId));
      $player_color = strval($game->getPlayerColorById($playerId));

      $args = [
        Industrialist::FIELD_PLAYER_ID => $playerId,
        Industrialist::FIELD_PLAYER_NO => $player_no,
        Industrialist::FIELD_PLAYER_NAME => $player_name,
        Industrialist::FIELD_PLAYER_COLOR => $player_color,
        Industrialist::FIELD_PLAYER_COLOR_NAME => self::COLOR_NAMES[$player_color],
        Industrialist::FIELD_PLAYER_ELIMINATED => false,
        Industrialist::FIELD_PLAYER_SCORE => 0,
        Industrialist::FIELD_PLAYER_SCORE_AUX => 0,
        Industrialist::FIELD_PLAYER_ZOMBIE => 0,
        Industrialist::FIELD_PLAYER_IS_TYCOON => $player_no == 1,
        Industrialist::FIELD_PLAYER_IS_NEXT_TYCOON => false
      ];

      $industrialist = new Industrialist($args);
      self::$industrialists[$playerId] = $industrialist;

      $filterKey = RegistryKeyPrefix::SEARCH_PLAYER_ID->value . "[" . $playerId . "]";
      $filter = FilterRegistry::instance()->getOrCreate(
        $filterKey,
        [
         "type" => FilterType::SIMPLE,
         "column" => Industrialist::COLUMN_PLAYER_ID,
         "dataType" => DT::INT,
         "operator" => OperatorType::EQUALS,
         "value" => $playerId 
        ]
      );

      // Update industrialist (player) data in db
      if ($filter != null) {
        $industrialist->update($args, $filter);
      }
    }

    // Initialize player counters
    self::initDb($players);
  }

  /**
   * Obtain the sum of power and fuel sector production of given player
   * @param int $playerId
   * @return int
   */
  public static function sumPowerAndFuelSectorProduction(int $playerId): int {
    return self::getPlayerCounterValue($playerId, self::COUNTER_INDUSTRIALIST_POWER) + self::getPlayerCounterValue($playerId, self::COUNTER_INDUSTRIALIST_FUEL);
  }
  /**
   * Obtain the sum of agro and transport sector production of given player
   * @param int $playerId
   * @return int
   */
  public static function sumAgroAndTransportSectorProduction(int $playerId): int {
    return self::getPlayerCounterValue($playerId, self::COUNTER_INDUSTRIALIST_AGRO) + self::getPlayerCounterValue($playerId, self::COUNTER_INDUSTRIALIST_TRANSPORT);
  }

  /**
   * Count the number of policy and industry cards owned by given player
   * @param int $playerId
   * @return int
   */
  public static function countPolicyIndustryCards(int $playerId): int {
    return self::getPlayerCounterValue($playerId, self::COUNTER_INDUSTRIALIST_POLICIES_GAINED) + self::getPlayerCounterValue($playerId, self::COUNTER_INDUSTRIALIST_INDUSTRIES_OWNED);
  }

  public static function getPlayerCounterValue(int $playerId, string $counterName) {
    $value = null;

    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $value = $counter->get($playerId);
    }

    return $value;
  }

  public static function getPlayerCounterValues(string $counterName) {
    $values = [];
    foreach (array_keys(self::$industrialists) as $playerId) {
      $values[$playerId] = self::getPlayerCounterValue($playerId, $counterName);
    }

    return $values;
  }

  public static function setPlayerCounterValue(int $playerId, string $counterName, int $value) {
    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $counter->set($playerId, $value);
    }
  }

  public static function incPlayerCounter(int $playerId, string $counterName, int $delta = 1) {
    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $counter->inc($playerId, $delta);
    }
  }

  public static function incAllPlayerCounters(string $counterName, int $delta = 1) {
    foreach (array_keys(self::$industrialists) as $playerId) {
      self::incPlayerCounter($playerId, $counterName, $delta);
    }
  }

  public static function decPlayerCounter(int $playerId, string $counterName, int $delta = 1) {
    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $counter->inc($playerId, 0 - $delta);
    }
  }

  public static function decAllPlayerCounters(string $counterName, int $delta = 1) {
    foreach (array_keys(self::$industrialists) as $playerId) {
      self::decPlayerCounter($playerId, $counterName, $delta);
    }
  }

  private static function initDb($players) {
    $counterNames = [
      self::COUNTER_INDUSTRIALIST_INFLUENCE,
      self::COUNTER_INDUSTRIALIST_INFLUENCE_RANK,
      self::COUNTER_INDUSTRIALIST_ASSET_VALUE,
      self::COUNTER_INDUSTRIALIST_FAVOR,
      self::COUNTER_INDUSTRIALIST_MONEY,
      self::COUNTER_INDUSTRIALIST_PROMOTERS_IN_HAND,
      self::COUNTER_INDUSTRIALIST_PROMOTERS_IN_POOL,
      self::COUNTER_INDUSTRIALIST_PROMISSARY_NOTES,
      self::COUNTER_INDUSTRIALIST_LOAN_INTAKE_LEVEL,
      self::COUNTER_INDUSTRIALIST_FINANCE,
      self::COUNTER_INDUSTRIALIST_FINANCE_RANK,
      self::COUNTER_INDUSTRIALIST_MINERALS,
      self::COUNTER_INDUSTRIALIST_MINERALS_RANK,
      self::COUNTER_INDUSTRIALIST_FUEL,
      self::COUNTER_INDUSTRIALIST_FUEL_RANK,
      self::COUNTER_INDUSTRIALIST_AGRO,
      self::COUNTER_INDUSTRIALIST_AGRO_RANK,
      self::COUNTER_INDUSTRIALIST_POWER,
      self::COUNTER_INDUSTRIALIST_POWER_RANK,
      self::COUNTER_INDUSTRIALIST_TRANSPORT,
      self::COUNTER_INDUSTRIALIST_TRANSPORT_RANK,
      self::COUNTER_INDUSTRIALIST_ACTIONS_REMAINING,
      self::COUNTER_INDUSTRIALIST_PLUS_ONE_ACTIONS_REMAINING,
      self::COUNTER_INDUSTRIALIST_TYCOON_ACTIONS_REMAINING,
      self::COUNTER_INDUSTRIALIST_SHARES_REMAINING,
      self::COUNTER_INDUSTRIALIST_LEAST_SHARE_VALUE,
      self::COUNTER_INDUSTRIALIST_UNBUILT_PLANTS,
      self::COUNTER_INDUSTRIALIST_BUILT_PLANTS,
      self::COUNTER_INDUSTRIALIST_POLICIES_GAINED,
      self::COUNTER_INDUSTRIALIST_INDUSTRIES_OWNED,
      self::COUNTER_INDUSTRIALIST_FINANCE_INDUSTRIES,
      self::COUNTER_INDUSTRIALIST_MINERALS_INDUSTRIES,
      self::COUNTER_INDUSTRIALIST_FUEL_INDUSTRIES,
      self::COUNTER_INDUSTRIALIST_AGRO_INDUSTRIES,
      self::COUNTER_INDUSTRIALIST_POWER_INDUSTRIES,
      self::COUNTER_INDUSTRIALIST_TRANSPORT_INDUSTRIES,
      self::COUNTER_INDUSTRIALIST_MERITS_IN_HAND
    ];

    $playerIds = array_keys($players);

    $game = Game::get();

    foreach ($counterNames as $counterName) {
      if (array_key_exists($counterName, self::$counters)) {
        $counter = self::$counters[$counterName];
      }
      else {
        $min = self::minCounterValue($counterName);
        $max = self::maxCounterValue($counterName);

        $counter = Game::get()->counterFactory->createPlayerCounter($counterName, $min, $max);
      }

      if (!is_null($counter) && $counter instanceof PlayerCounter) {
        // Initialize database for counter for all players
        $counter->initDb($playerIds, 0);

        // Set counter value depending on the counter name
        foreach ($playerIds as $playerId) {
          $initialValue = self::initialValue($counterName, $game->getPlayerNoById($playerId));
          if ($initialValue > 0) {
            $counter->set($playerId, $initialValue);
          }
        }
      }

      self::$counters[$counterName] = $counter;
    }
  }

  protected static function loadFromDb(int $playerId) {
    $industrialist = null;

    // Retrieve or create filter
    $filterKey = RegistryKeyPrefix::SEARCH_PLAYER_ID . "[" . $playerId . "]";
    $filter = FilterRegistry::instance()->getOrCreate(
      $filterKey,
      [
        "type" => FilterType::SIMPLE,
        "column" => Industrialist::COLUMN_PLAYER_ID,
        "dataType" => DT::INT,
        "operator" => OperatorType::EQUALS,
        "value" => $playerId 
      ]
    );

    // Create select query
    $query = new SelectDBQuery(
      Industrialist::TABLE_NAME,
      array_keys(Industrialist::dbFieldMappings()),
      $filter,
      Industrialist::COLUMN_PLAYER_ID,
      OrderByDirection::ASC,
      1,
      true,
      false
    );

    // Get and process query result
    $queryResult = DBManager::execute($query);
    if (!is_null($queryResult) && $queryResult instanceof DBQueryResult && $queryResult->getStatus() == QueryStatus::SUCCESS->name) {
      $result = $queryResult->getResult();
      if (is_array($result)) {
        $game = Game::get();

        $player_no = intval($game->getPlayerNoById($playerId));
        $player_name = strval($game->getPlayerNameById($playerId));
        $player_color = strval($game->getPlayerColorById($playerId));

        $args = [
          Industrialist::FIELD_PLAYER_ID => $playerId,
          Industrialist::FIELD_PLAYER_NO => $player_no,
          Industrialist::FIELD_PLAYER_NAME => $player_name,
          Industrialist::FIELD_PLAYER_COLOR => $player_color,
          Industrialist::FIELD_PLAYER_COLOR_NAME => self::COLOR_NAMES[$player_color],
          Industrialist::FIELD_PLAYER_ELIMINATED => $result[Industrialist::COLUMN_PLAYER_ELIMINATED] == 1,
          Industrialist::FIELD_PLAYER_SCORE => $result[Industrialist::COLUMN_PLAYER_SCORE],
          Industrialist::FIELD_PLAYER_SCORE_AUX => $result[Industrialist::COLUMN_PLAYER_SCORE_AUX],
          Industrialist::FIELD_PLAYER_ZOMBIE => $result[Industrialist::COLUMN_PLAYER_ZOMBIE] == 1,
          Industrialist::FIELD_PLAYER_IS_TYCOON => $result[Industrialist::COLUMN_PLAYER_IS_TYCOON] == 1,
          Industrialist::FIELD_PLAYER_IS_NEXT_TYCOON => $result[Industrialist::COLUMN_PLAYER_IS_NEXT_TYCOON] == 1
        ];

        $industrialist = new Industrialist($args);
        self::$industrialists[$playerId] = $industrialist;
      }
    }

    return $industrialist;
  }

  /**
   * Return industrialist object for given player id
   * @param int $playerId
   * @return Industrialist
   */
  public static function get(int $playerId): Industrialist {
    $industrialist = null;
    if (array_key_exists($playerId, self::$industrialists)) {
      $industrialist = self::$industrialists[$playerId];
    }
    else {
      $industrialist = self::loadFromDb($playerId);
    }

    return $industrialist;
  }

  public static function getAll() {
    if (empty(self::$industrialists)) {
      // If no industrialists exist in memory, then load them from the database
      $queryResult = DBManager::execute(new SelectDBQuery(
        Industrialist::TABLE_NAME,
        array_keys(Industrialist::dbFieldMappings()),
        null
      ));

      if ($queryResult != null && $queryResult instanceof DBQueryResult && $queryResult->getStatus() == QueryStatus::SUCCESS) {
        $result = $queryResult->getResult();
        if (is_array($result)) {
          $args = [];
          foreach ($result as $column => $value) {
            $field = Industrialist::dbFieldMappings()[$column];
            if ($field != null) {
              $args[$field["name"]] = DataUtil::getValue($value, $field["type"]);
            }
          }

          $industrialist = new Industrialist($args);
          self::$industrialists[] = $industrialist;
        }
      }
    }

    return self::$industrialists;
  }

  public static function initialValue($counterName, $player_no) {
    $value = 0;

    if ($counterName == self::COUNTER_INDUSTRIALIST_INFLUENCE) {
      $value = self::initialInfluence($player_no);
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_MONEY) {
      $value = self::initialMoney($player_no);
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_PROMOTERS_IN_HAND) {
      $value = self::intialPromotersInHand($player_no);
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_LOAN_INTAKE_LEVEL) {
      $value = self::INITIAL_LOAN_INTAKE_LEVEL;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_ACTIONS_REMAINING) {
      $value = self::INITIAL_ACTIONS;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_TYCOON_ACTIONS_REMAINING) {
      $value = $player_no == 1 ? 1 : 0;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_SHARES_REMAINING) {
      $value = self::INITIAL_SHARES;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_LEAST_SHARE_VALUE) {
      $value = self::INITIAL_SHARE_VALUE;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_UNBUILT_PLANTS) {
      $value = self::INITIAL_UNBUILT_PLANTS;
    }

    return $value;
  }

  /**
   * Minimum value given counter can have
   * @param string $counterName
   * @return int
   */
  private static function minCounterValue(string $counterName) {
    $min = self::MIN_DEFAULT;
    if ($counterName == self::COUNTER_INDUSTRIALIST_LOAN_INTAKE_LEVEL) {
      $min = self::MIN_LOAN_INTAKE_LEVEL;
    }

    return $min;
  }

  /**
   * Maximum value given counter can have
   * @param string $counterName
   * @return int|null
   */
  private static function maxCounterValue(string $counterName) {
    $max = null;
    if ($counterName == self::COUNTER_INDUSTRIALIST_LOAN_INTAKE_LEVEL) {
      $max = self::MAX_LOAN_INTAKE_LEVEL;
    }
    elseif (str_contains("rank", $counterName)) {
      $max = self::MAX_RANK;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_PROMISSARY_NOTES) {
      $max = self::MAX_PROMISSARY_NOTES;
    }
    elseif (in_array($counterName, [self::COUNTER_INDUSTRIALIST_FINANCE, self::COUNTER_INDUSTRIALIST_MINERALS, self::COUNTER_INDUSTRIALIST_FUEL, self::COUNTER_INDUSTRIALIST_AGRO, self::COUNTER_INDUSTRIALIST_POWER, self::COUNTER_INDUSTRIALIST_TRANSPORT])) {
      $max = self::MAX_SECTOR_LEVEL;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_ACTIONS_REMAINING) {
      $max = self::MAX_ACTIONS;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_TYCOON_ACTIONS_REMAINING) {
      $max = self::MAX_TYCOON_ACTIONS;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_SHARES_REMAINING) {
      $max = self::MAX_SHARES_REMAINING;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_UNBUILT_PLANTS) {
      $max = self::MAX_UNBUILT_PLANTS;
    }
    elseif ($counterName == self::COUNTER_INDUSTRIALIST_BUILT_PLANTS) {
      $max = self::MAX_BUILT_PLANTS;
    }

    return $max;
  }

  /**
   * Return initial setup influence for player
   * @param int $player_no
   * @return int
   */
  private static function initialInfluence(int $player_no): int {
    return Game::get()->getPlayersNumber() + 1 - $player_no;
  }

  /**
   * Return initial setup money for player
   * @param int $player_no
   * @return int
   */
  private static function initialMoney(int $player_no) {
    return $player_no == 1 ? self::INITIAL_MONEY_TYCOON : self::INITIAL_MONEY;
  }

  /**
   * Return initial setup promoters in hand for player
   * @param int $player_no
   * @return int
   */
  private static function intialPromotersInHand(int $player_no): int {
    return 7 - self::initialInfluence($player_no);
  }

  /** Constants - Misc */
  const COLOR_NAMES = ["a24341" => "red", "2f6534" => "green", "3a7094" => "blue", "bea227" => "yellow"];

  /** Constants - Initial Values */
  const INITIAL_MONEY = 150;
  const INITIAL_MONEY_TYCOON = 130;
  const INITIAL_LOAN_INTAKE_LEVEL = 30;
  const INITIAL_ACTIONS = 2;
  const INITIAL_SHARES = 9;
  const INITIAL_SHARE_VALUE = 30;
  const INITIAL_SHARE_VALUES = [30, 35, 40, 45, 50, 55, 60, 65, 70];
  const INITIAL_UNBUILT_PLANTS = 9;

  /** Constants - Min and Max Values */
  const MIN_DEFAULT = 0;
  const MAX_RANK = 4;
  const MIN_LOAN_INTAKE_LEVEL = 30;
  const MAX_LOAN_INTAKE_LEVEL = 60;
  const MAX_PROMISSARY_NOTES = 7;
  const MAX_SECTOR_LEVEL = 7;
  const MAX_ACTIONS = 2;
  const MAX_TYCOON_ACTIONS = 1;
  const MAX_SHARES_REMAINING = 9;
  const MAX_UNBUILT_PLANTS = 9;
  const MAX_BUILT_PLANTS = 9;

  /** Constants - DB Columns */
  const COLUMN_PLAYER_ID = "playerId";

  /** Constants - Counters - Indicators */
  const COUNTER_INDUSTRIALIST_INFLUENCE = "influence";
  const COUNTER_INDUSTRIALIST_INFLUENCE_RANK = "influence_rank";
  const COUNTER_INDUSTRIALIST_ASSET_VALUE = "asset_value";
  const COUNTER_INDUSTRIALIST_FAVOR = "favor";
  const COUNTER_INDUSTRIALIST_MONEY = "money";
  const COUNTER_INDUSTRIALIST_PROMOTERS_IN_HAND = "promoters_in_hand";
  const COUNTER_INDUSTRIALIST_PROMOTERS_IN_POOL = "promoters_in_pool";
  const COUNTER_INDUSTRIALIST_PROMISSARY_NOTES = "promissary_notes";
  const COUNTER_INDUSTRIALIST_LOAN_INTAKE_LEVEL = "loan_intake_level";

  /** Constants - Counters - Sector Production */
  const COUNTER_INDUSTRIALIST_FINANCE = "finance";
  const COUNTER_INDUSTRIALIST_FINANCE_RANK = "finance_rank";
  const COUNTER_INDUSTRIALIST_MINERALS = "minerals";
  const COUNTER_INDUSTRIALIST_MINERALS_RANK = "minerals_rank";
  const COUNTER_INDUSTRIALIST_FUEL = "fuel";
  const COUNTER_INDUSTRIALIST_FUEL_RANK = "fuel_rank";
  const COUNTER_INDUSTRIALIST_AGRO = "agro";
  const COUNTER_INDUSTRIALIST_AGRO_RANK = "agro_rank";
  const COUNTER_INDUSTRIALIST_POWER = "power";
  const COUNTER_INDUSTRIALIST_POWER_RANK = "power_rank";
  const COUNTER_INDUSTRIALIST_TRANSPORT = "transport";
  const COUNTER_INDUSTRIALIST_TRANSPORT_RANK = "transport_rank";
  
  /** Constants - Counters - Actions */
  const COUNTER_INDUSTRIALIST_ACTIONS_REMAINING = "actions_remaining";
  const COUNTER_INDUSTRIALIST_PLUS_ONE_ACTIONS_REMAINING = "plus_one_actions_remaining";
  const COUNTER_INDUSTRIALIST_TYCOON_ACTIONS_REMAINING = "tycoon_actions_remaining";

  /** Constants - Counters - Misc */
  const COUNTER_INDUSTRIALIST_SHARES_REMAINING = "shares_remaining";
  const COUNTER_INDUSTRIALIST_LEAST_SHARE_VALUE = "least_share_value";
  const COUNTER_INDUSTRIALIST_UNBUILT_PLANTS = "unbuilt_plants";
  const COUNTER_INDUSTRIALIST_BUILT_PLANTS = "built_plants";
  const COUNTER_INDUSTRIALIST_POLICIES_GAINED = "policies_gained";
  const COUNTER_INDUSTRIALIST_INDUSTRIES_OWNED = "industries_owned";
  const COUNTER_INDUSTRIALIST_FINANCE_INDUSTRIES = "finance_industries";
  const COUNTER_INDUSTRIALIST_MINERALS_INDUSTRIES = "minerals_industries";
  const COUNTER_INDUSTRIALIST_FUEL_INDUSTRIES = "fuel_industries";
  const COUNTER_INDUSTRIALIST_AGRO_INDUSTRIES = "agro_industries";
  const COUNTER_INDUSTRIALIST_POWER_INDUSTRIES = "power_industries";
  const COUNTER_INDUSTRIALIST_TRANSPORT_INDUSTRIES = "transport_industries";
  const COUNTER_INDUSTRIALIST_MERITS_IN_HAND = "merits_in_hand";
}