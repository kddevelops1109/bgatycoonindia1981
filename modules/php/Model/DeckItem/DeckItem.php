<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem;

use Bga\Games\tycoonindianew\Contracts\Occupiable;
use Bga\Games\tycoonindianew\Contracts\Placeable;

use Bga\Games\tycoonindianew\Model\DBObject as DBO;

use Bga\Games\tycoonindianew\Registry\FilterRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

USE Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\OperatorType;

use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * @property int $itemId Unique identifier of the item (corresponds to the cardId in BGA deck component)
 * @property string $itemType Type of item
 * @property int $itemTypeArg Type arg of item
 * @property string $itemLocation Location of item
 * @property int $itemLocationArg Location arg of item
 * @property string $itemName Name of item
 * @property int $nbr Number of instances of this item
 */
abstract class DeckItem extends DBO implements Placeable {
  

  public function __construct($args) {
    $this->primaryKey = self::dbFieldMappings()[self::COLUMN_ITEM_ID];
    if (!array_key_exists(self::FIELD_ITEM_NAME, $args)) {
      $args[self::FIELD_ITEM_NAME] = static::NAME;
    }

    parent::__construct($args);
  }

  /**
   * DB Field mappings common to all deck items
   * @return array{column: string, name: string, readOnly: bool, type: DT[]}
   */
  public static function dbFieldMappings(): array {
    return [
      ...parent::dbFieldMappings(),
      ...[
        self::COLUMN_ITEM_ID => ["name" => self::FIELD_ITEM_ID, "type" => DT::INT, "column" => self::COLUMN_ITEM_ID, "readOnly" => true],
        self::COLUMN_ITEM_TYPE => ["name" => self::FIELD_ITEM_TYPE, "type" => DT::STRING, "column" => self::COLUMN_ITEM_TYPE, "readOnly" => false],
        self::COLUMN_ITEM_TYPE_ARG => ["name" => self::FIELD_ITEM_TYPE_ARG, "type" => DT::INT, "column" => self::COLUMN_ITEM_TYPE_ARG, "readOnly" => false],
        self::COLUMN_ITEM_LOCATION => ["name" => self::FIELD_ITEM_LOCATION, "type" => DT::STRING, "column" => self::COLUMN_ITEM_LOCATION, "readOnly" => false],
        self::COLUMN_ITEM_LOCATION_ARG => ["name" => self::FIELD_ITEM_LOCATION_ARG, "type" => DT::INT, "column" => self::COLUMN_ITEM_LOCATION_ARG, "readOnly" => false],
        self::COLUMN_ITEM_NAME => ["name" => self::FIELD_ITEM_NAME, "type" => DT::STRING, "column" => self::COLUMN_ITEM_NAME, "readOnly" => false]
      ]
    ];
  }

  /**
   * Static fields list common to all deck items, if any
   * @return array
   */
  public static function staticFieldsList(): array {
    return [
      ...parent::staticFieldsList(),
      ...[self::FIELD_NBR]
    ];
  }

  /**
   * Static field args common to all deck items, if any
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      ...[self::FIELD_NBR => static::NBR]
    ];
  }

  /**
   * This loads a new instance of a deck item given the item name
   * @param string $itemName
   * @return DeckItem|null
   */
  public static function fromDbByName(string $itemName): ?DeckItem {
    $filter = FilterRegistry::instance()->getOrCreate(
      RegistryKeyPrefix::SEARCH_DECK_ITEM_BY_NAME . "_" . StringUtil::strSnakeCase($itemName),
      [
        "type" => FilterType::SIMPLE,
        "column" => self::COLUMN_ITEM_NAME,
        "dataType" => DT::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => $itemName
      ]
    );

    return static::fromDb($filter);
  }

  /**
   * Load deck item from DB for given item id
   * @param string $itemId
   * @return DeckItem|null
   */
  public static function fromDbById(string $itemId): ?DeckItem {
    $filter = FilterRegistry::instance()->getOrCreate(
      RegistryKeyPrefix::SEARCH_DECK_ITEM_BY_ID . "_" . StringUtil::strSnakeCase($itemId),
      [
        "type" => FilterType::SIMPLE,
        "column" => self::COLUMN_ITEM_ID,
        "dataType" => DT::INT,
        "operator" => OperatorType::EQUALS,
        "value" => $itemId
      ]
    );

    return static::fromDb($filter);
  }

  /**
   * Place deck item on occupiable space
   * @param Occupiable $occupiable
   * @return void
   */
  public function place(Occupiable $occupiable) {
    $occupiable->occupy($this);
  }

  /**
   * Constants - DB Fields
   */
  const FIELD_ITEM_ID = "id";
  const FIELD_ITEM_TYPE = "type";
  const FIELD_ITEM_TYPE_ARG = "typeArg";
  const FIELD_ITEM_LOCATION = "location";
  const FIELD_ITEM_LOCATION_ARG = "locationArg";
  const FIELD_ITEM_NAME = "name";
  const FIELD_NBR = "nbr";

  /** Constants - DB Columns */
  const COLUMN_ITEM_ID = "card_id";
  const COLUMN_ITEM_TYPE = "card_type";
  const COLUMN_ITEM_TYPE_ARG = "card_type_arg";
  const COLUMN_ITEM_LOCATION = "card_location";
  const COLUMN_ITEM_LOCATION_ARG = "card_location_arg";
  const COLUMN_ITEM_NAME = "name";

  /** Constants - Misc */
  const OBJECT_NAME_DECK = "module.common.deck";
}