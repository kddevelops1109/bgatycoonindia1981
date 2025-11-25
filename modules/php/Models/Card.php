<?php
namespace Bga\Games\tycoonindianew\Models;

use Bga\Games\tycoonindianew\Util\DataUtil;

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
abstract class Card extends DBObject {

  public function __construct($arr) {
    $this->table = self::TABLE_NAME;
    $this->primaryKey = self::dbFieldMappings()[self::COLUMN_CARD_ID];
    $this->dbFields = self::dbFieldMappings();
    $this->staticFields = self::staticFieldMappings();

    return parent::__construct($arr);
  }

  public static function dbFieldMappings() {
    return [
      self::COLUMN_CARD_ID => ["name" => self::FIELD_CARD_ID, "type" => DataUtil::DATA_TYPE_INT, "column" => self::COLUMN_CARD_ID, "readOnly" => true],
      self::COLUMN_CARD_TYPE => ["name" => self::FIELD_CARD_TYPE, "type" => DataUtil::DATA_TYPE_STRING, "column" => self::COLUMN_CARD_TYPE, "readOnly" => false],
      self::COLUMN_CARD_TYPE_ARG => ["name" => self::FIELD_CARD_TYPE_ARG, "type" => DataUtil::DATA_TYPE_INT, "column" => self::COLUMN_CARD_TYPE_ARG, "readOnly" => false],
      self::COLUMN_CARD_LOCATION => ["name" => self::FIELD_CARD_LOCATION, "type" => DataUtil::DATA_TYPE_STRING, "column" => self::COLUMN_CARD_LOCATION, "readOnly" => false],
      self::COLUMN_CARD_LOCATION_ARG => ["name" => self::FIELD_CARD_LOCATION_ARG, "type" => DataUtil::DATA_TYPE_INT, "column" => self::COLUMN_CARD_LOCATION_ARG, "readOnly" => false],
      self::COLUMN_CARD_NAME => ["name" => self::FIELD_CARD_NAME, "type" => DataUtil::DATA_TYPE_STRING, "column" => self::COLUMN_CARD_NAME, "readOnly" => false],
      self::COLUMN_CARD_PROMOTERS => ["name" => self::FIELD_CARD_PROMOTERS, "type" => DataUtil::DATA_TYPE_INT, "column" => self::COLUMN_CARD_PROMOTERS, "readOnly" => false]
    ];
  }

  public static function staticFieldMappings() {
    return [];
  }

  /**
   * Constants
   */
  const TABLE_NAME = "tycoon_card";

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
}