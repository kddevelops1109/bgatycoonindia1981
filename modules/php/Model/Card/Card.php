<?php
namespace Bga\Games\tycoonindianew\Model\Card;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Filter\DBFilter;

use Bga\Games\tycoonindianew\Contracts\Fungible;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;
use Bga\Games\tycoonindianew\Manager\DBManager;

use Bga\Games\tycoonindianew\Model\DBObject as DBO;
use Bga\Games\tycoonindianew\Query\SelectDBQuery;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\FilterRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\OperatorType;
use Bga\Games\tycoonindianew\Type\QueryStatus;

use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Represents all Tycoon Card. These are Corporate Agendas, Policies, Industries and Merits
 * @property int $cardId
 * @property string $cardType
 * @property int $cardTypeArg
 * @property string $cardLocation
 * @property int $cardLocationArg
 * @property string $cardName
 * @property int $cardPromoters
 */
abstract class Card extends DBO implements Fungible {

  protected static int $topOfDeck = 1;

  public function __construct($args) {
    $this->primaryKey = self::dbFieldMappings()[self::COLUMN_CARD_ID];
    if (!array_key_exists(self::FIELD_CARD_NAME, $args)) {
      $args[self::FIELD_CARD_NAME] = static::NAME;
    }

    parent::__construct($args);
  }

  public static function dbFieldMappings() {
    return [
      self::COLUMN_CARD_ID => ["name" => self::FIELD_CARD_ID, "type" => DT::INT, "column" => self::COLUMN_CARD_ID, "readOnly" => true],
      self::COLUMN_CARD_TYPE => ["name" => self::FIELD_CARD_TYPE, "type" => DT::STRING, "column" => self::COLUMN_CARD_TYPE, "readOnly" => false],
      self::COLUMN_CARD_TYPE_ARG => ["name" => self::FIELD_CARD_TYPE_ARG, "type" => DT::INT, "column" => self::COLUMN_CARD_TYPE_ARG, "readOnly" => false],
      self::COLUMN_CARD_LOCATION => ["name" => self::FIELD_CARD_LOCATION, "type" => DT::STRING, "column" => self::COLUMN_CARD_LOCATION, "readOnly" => false],
      self::COLUMN_CARD_LOCATION_ARG => ["name" => self::FIELD_CARD_LOCATION_ARG, "type" => DT::INT, "column" => self::COLUMN_CARD_LOCATION_ARG, "readOnly" => false],
      self::COLUMN_CARD_NAME => ["name" => self::FIELD_CARD_NAME, "type" => DT::STRING, "column" => self::COLUMN_CARD_NAME, "readOnly" => false],
      self::COLUMN_CARD_PROMOTERS => ["name" => self::FIELD_CARD_PROMOTERS, "type" => DT::INT, "column" => self::COLUMN_CARD_PROMOTERS, "readOnly" => false]
    ];
  }

  /**
   * Static fields list for all cards
   * @return array
   */
  public static function staticFieldsList(): array {
    return [];
  }

  /**
   * Static field args common to all cards, if any
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [];
  }

  /**
   * Called whenever a card is placed on the top of the deck or removed from the top of the deck
   * @param $remove True if card was removed from the top of the deck
   * @return int
   */
  public static function topOfDeck(bool $remove = false) {
    return $remove ? self::$topOfDeck-- : self::$topOfDeck++;
  }

  /**
   * This loads a new instance of a card given a card name
   * @param string $cardName
   * @return Card|null
   */
  public static function fromDbByName(string $cardName): ?Card {
    $filter = FilterRegistry::instance()->getOrCreate(
      RegistryKeyPrefix::SEARCH_CARD_BY_NAME . "_" . StringUtil::strSnakeCase($cardName),
      [
        "type" => FilterType::SIMPLE,
        "column" => self::COLUMN_CARD_NAME,
        "dataType" => DT::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => $cardName
      ]
    );

    return self::fromDb($filter);
  }

  /**
   * Load card from DB for given card id
   * @param string $cardId
   * @return Card|null
   */
  public static function fromDbById(string $cardId): ?Card {
    $filter = FilterRegistry::instance()->getOrCreate(
      RegistryKeyPrefix::SEARCH_CARD_BY_NAME . "_" . StringUtil::strSnakeCase($cardId),
      [
        "type" => FilterType::SIMPLE,
        "column" => self::COLUMN_CARD_ID,
        "dataType" => DT::INT,
        "operator" => OperatorType::EQUALS,
        "value" => $cardId
      ]
    );

    return self::fromDb($filter);
  }

  /**
   * Load card from DB for given filter
   * @param DBFilter $filter
   * @return Card|null
   */
  public static function fromDb(DBFilter $filter): ?Card {
    $query = new SelectDBQuery(self::TABLE_NAME, array_keys(self::dbFieldMappings()), $filter, null, null, 1, true, true);

    $queryResult = DBManager::execute($query);

    if (!is_null($queryResult) && $queryResult->getStatus() == QueryStatus::SUCCESS) {
      $cardDetails = $queryResult->getResult();
      if (is_array($cardDetails)) {
        $cardTypeName = $cardDetails[self::COLUMN_CARD_NAME];
        $cardClassName = str_replace(" ", "", $cardTypeName);
        
        if (in_array($cardTypeName, [CardType::INDUSTRY, CardType::POLICY, CardType::PLANNING_COMMISSION])) {
          $cardClassName = self::CLASSPATH . $cardClassName . "\\" . $cardClassName . "\\Card";
        }
        else {
          $cardClassName = self::CLASSPATH . $cardClassName . "\\Card";
        }

        $classpath = $cardClassName::CLASSPATH;

        // Final class name of specific card to load from db
        $className = $classpath . "\\" . str_replace(" ", "", $cardDetails[self::COLUMN_CARD_NAME]);
        if (!is_null($className)) {
          return new $className($cardDetails);
        }
      }
    }

    return null;
  }

  /**
   * Play methods
   */

  // abstract public function play();

  /**
   * Effect Handling methods
   */

  /**
   * Assign given effect to the specific card, based on provided args.
   * Args are expected to have the following:
   * - Name of effect field
   * - Type (Effect type)
   * - Gain/Loss
   * - Fungible type
   * - Amount
   * - Multiplier
   * - Condition, if any
   * - Spec, if any
   * - Trigger, if any
   * - Round down
   * @param array $args
   * @return void
   */
  protected function assignEffect(array $args): void {
    $fieldName = $args["fieldName"];
    $this->$fieldName = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Evaluate and apply the given effect for this card
   * @param string $playerId ID of the player to apply effect to
   * @param string $fieldName Name of the effect field
   * @return void
   */
  protected function applyEffect(int $playerId, string $fieldName): void {
    $effect = $this->$fieldName;
    if ($effect instanceof Effect) {
      $effect->apply($playerId);
    }
  }

  /**
   * Evaluate the given effect for this card, but do not apply it, just return it to serve the purpose of a review
   * @param int $playerId
   * @param string $fieldName
   * @return int
   */
  protected function previewEffect(int $playerId, string $fieldName): int {
    $effect = $this->$fieldName;
    if ($effect instanceof Effect) {
      return $effect->preview($playerId);
    }

    return 0;
  }

  /**
   * Constants - Misc
   */
  const TABLE_NAME = "tycoon_card";
  const OBJECT_NAME_DECK = "module.common.deck";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Model\Card\\";

  /**
   * Constants - DB Fields
   */
  const FIELD_CARD_ID = "cardId";
  const FIELD_CARD_TYPE = "cardType";
  const FIELD_CARD_TYPE_ARG = "cardTypeArg";
  const FIELD_CARD_LOCATION = "cardLocation";
  const FIELD_CARD_LOCATION_ARG = "cardLocationArg";
  const FIELD_CARD_NAME = "cardName";
  const FIELD_CARD_PROMOTERS = "cardPromoters";

  /**
   * Constants - DB Columns
   */

  const COLUMN_CARD_ID = "card_id";
  const COLUMN_CARD_TYPE = "card_type";
  const COLUMN_CARD_TYPE_ARG = "card_type_arg";
  const COLUMN_CARD_LOCATION = "card_location";
  const COLUMN_CARD_LOCATION_ARG = "card_location_arg";
  const COLUMN_CARD_NAME = "card_name";
  const COLUMN_CARD_PROMOTERS = "card_promoters";

  /**
   * Constants - Age
   */
  const AGE_I = "Age 1";
  const AGE_II = "Age 2";
}