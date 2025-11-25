<?php
namespace Bga\Games\tycoonindianew\Managers;

use Bga\GameFramework\Components\Counters\PlayerCounter;
use Bga\Games\tycoonindianew\DB\Filter\SimpleDBFilter;
use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\DB\Query\SelectDBQuery;
use Bga\Games\tycoonindianew\DB\Query\DBQueryResult;

use Bga\Games\tycoonindianew\Models\Industrialist;

use Bga\Games\tycoonindianew\Util\DataUtil;

class IndustrialistsManager {

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

  /*********************************************************************************************/
  /***************************************NEW GAME SETUP****************************************/
  /*********************************************************************************************/
  
  /**
   * Setup industrialists at the start of a new game for given players
   * @param array $players
   * @return void
   */
  public static function setupNewGame($players) {
    foreach ($players as $player_id => $player) {
      $player_no = intval(Game::get()->getPlayerNoById($player_id));
      $player_name = strval(Game::get()->getPlayerNameById($player_id));
      $player_color = strval(Game::get()->getPlayerColorById($player_id));

      $arr = [
        Industrialist::FIELD_PLAYER_ID => $player_id,
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

      $industrialist = new Industrialist($arr);
      self::$industrialists[$player_id] = $industrialist;

      $operator = SimpleDBFilter::OPERATOR_EQUALS;

      // Update industrialist (player) data in db
      $industrialist->update($arr, new SimpleDBFilter(Industrialist::COLUMN_PLAYER_ID, DataUtil::DATA_TYPE_INT, $operator, $player_id));
    }

    // Initialize player counters
    self::initDb($players);
  }

  public static function getPlayerCounterValue(int $player_id, string $counterName) {
    $value = null;

    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $value = $counter->get($player_id);
    }

    return $value;
  }

  public static function getPlayerCounterValues(string $counterName) {
    $values = [];
    foreach (array_keys(self::$industrialists) as $player_id) {
      $values[$player_id] = self::getPlayerCounterValue($player_id, $counterName);
    }

    return $values;
  }

  public static function setPlayerCounterValue(int $player_id, string $counterName, int $value) {
    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $counter->set($player_id, $value);
    }
  }

  public static function incPlayerCounter(int $player_id, string $counterName, int $delta = 1) {
    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $counter->inc($player_id, $delta);
    }
  }

  public static function incAllPlayerCounters(string $counterName, int $delta = 1) {
    foreach (array_keys(self::$industrialists) as $player_id) {
      self::incPlayerCounter($player_id, $counterName, $delta);
    }
  }

  public static function decPlayerCounter(int $player_id, string $counterName, int $delta = 1) {
    $counter = self::$counters[$counterName];
    if (!is_null($counter) && $counter instanceof PlayerCounter) {
      $counter->inc($player_id, 0 - $delta);
    }
  }

  public static function decAllPlayerCounters(string $counterName, int $delta = 1) {
    foreach (array_keys(self::$industrialists) as $player_id) {
      self::decPlayerCounter($player_id, $counterName, $delta);
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
      self::COUNTER_INDUSTRIALIST_POLICIES_GAINED,
      self::COUNTER_INDUSTRIALIST_UNBUILT_INDUSTRIES,
      self::COUNTER_INDUSTRIALIST_BUILT_INDUSTRIES
    ];

    $player_ids = array_keys($players);

    $game = Game::get();

    foreach ($counterNames as $counterName) {
      if (array_key_exists($counterName, self::$counters)) {
        $counter = self::$counters[$counterName];
      }
      else {
        $counter = Game::get()->counterFactory->createPlayerCounter($counterName);
      }

      if (!is_null($counter) && $counter instanceof PlayerCounter) {
        // Initialize database for counter for all players
        $counter->initDb($player_ids, 0);

        // Set counter value depending on the counter name
        foreach ($player_ids as $player_id) {
          $initialValue = self::initialValue($counterName, $game->getPlayerNoById($player_id));
          if ($initialValue > 0) {
            self::setPlayerCounterValue($player_id, $counterName, $initialValue);
          }
        }
      }

      self::$counters[$counterName] = $counter;
    }
  }

  public static function getAll() {
    if (empty(self::$industrialists)) {
      // If no industrialists exist in memory, then load them from the database
      $queryResult = DBManager::execute(new SelectDBQuery(
        Industrialist::TABLE_NAME,
        array_keys(Industrialist::dbFieldMappings())
      ));

      if ($queryResult != null && $queryResult instanceof DBQueryResult && $queryResult->getStatus() == DBQueryResult::STATUS_SUCCESS) {
        $result = $queryResult->getResult();
        if (is_array($result)) {
          $arr = [];
          foreach ($result as $column => $value) {
            $field = Industrialist::dbFieldMappings()[$column];
            if ($field != null) {
              $arr[$field["name"]] = DataUtil::getValue($value, $field["type"]);
            }
          }

          $industrialist = new Industrialist($arr);
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

  /** Constants - DB Columns */
  const COLUMN_PLAYER_ID = "player_id";
  const COUNTER_INDUSTRIALIST_INFLUENCE = "influence";
  const COUNTER_INDUSTRIALIST_INFLUENCE_RANK = "influence_rank";
  const COUNTER_INDUSTRIALIST_ASSET_VALUE = "asset_value";
  const COUNTER_INDUSTRIALIST_FAVOR = "favor";
  const COUNTER_INDUSTRIALIST_MONEY = "money";
  const COUNTER_INDUSTRIALIST_PROMOTERS_IN_HAND = "promoters_in_hand";
  const COUNTER_INDUSTRIALIST_PROMOTERS_IN_POOL = "promoters_in_pool";
  const COUNTER_INDUSTRIALIST_PROMISSARY_NOTES = "promissary_notes";
  const COUNTER_INDUSTRIALIST_LOAN_INTAKE_LEVEL = "loan_intake_level";
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
  const COUNTER_INDUSTRIALIST_ACTIONS_REMAINING = "actions_remaining";
  const COUNTER_INDUSTRIALIST_PLUS_ONE_ACTIONS_REMAINING = "plus_one_actions_remaining";
  const COUNTER_INDUSTRIALIST_TYCOON_ACTIONS_REMAINING = "tycoon_actions_remaining";
  const COUNTER_INDUSTRIALIST_SHARES_REMAINING = "shares_remaining";
  const COUNTER_INDUSTRIALIST_LEAST_SHARE_VALUE = "least_share_value";
  const COUNTER_INDUSTRIALIST_UNBUILT_PLANTS = "unbuilt_plants";
  const COUNTER_INDUSTRIALIST_POLICIES_GAINED = "policies_gained";
  const COUNTER_INDUSTRIALIST_UNBUILT_INDUSTRIES = "unbuilt_industries";
  const COUNTER_INDUSTRIALIST_BUILT_INDUSTRIES = "built_industries";
}