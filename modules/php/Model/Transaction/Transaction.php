<?php
namespace Bga\Games\tycoonindianew\Model\Transaction;

use Bga\Games\tycoonindianew\Model\DBObject;
use Bga\Games\tycoonindianew\Type\DataType;
use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Transaction impacting industrialist(s) or between industrialists
 * @property string $id
 * @property string $state
 * @property int $round
 * @property string $details
 * @property array $promises
 */
class Transaction extends DBObject {

  protected function __construct($args) {
    $this->dbFields = self::dbFieldMappings();

    if (!array_key_exists(self::FIELD_ID, $args)) {
      $args[self::FIELD_ID] = StringUtil::uuid();
    }

    parent::__construct($args);
  }

  public static function dbFieldMappings() {
    return [
      self::COLUMN_ID => ["column" => self::COLUMN_ID, "name" => self::FIELD_ID, "type" => DataType::STRING, "readOnly" => false],
      self::COLUMN_STATE => ["column" => self::COLUMN_STATE, "name" => self::FIELD_STATE, "type" => DataType::STRING, "readOnly" => false],
      self::COLUMN_ROUND => ["column" => self::COLUMN_ROUND, "name" => self::FIELD_ROUND, "type" => DataType::INT, "readOnly" => false],
      self::COLUMN_DETAILS => ["column" => self::COLUMN_DETAILS, "name" => self::FIELD_DETAILS, "type" => DataType::STRING, "readOnly" => false],
      self::COLUMN_PROMISES => ["column" => self::COLUMN_PROMISES, "name" => self::FIELD_PROMISES, "type" => DataType::OBJ, "readOnly" => false]
    ];
  }

  public static function staticFieldsList() {
    return [];
  }

  /**
   * Constants - Misc
   */
  const TABLE_NAME = "tycoon_transaction";

  /**
   * Constants - DB Fields
   */
  const FIELD_ID = "id";
  const FIELD_STATE = "state";
  const FIELD_ROUND = "round";
  const FIELD_DETAILS = "details";
  const FIELD_PROMISES = "promises";

  /**
   * Constants - Columns
   */
  const COLUMN_ID = "id";
  const COLUMN_STATE = "state";
  const COLUMN_ROUND = "round";
  const COLUMN_DETAILS = "details";
  const COLUMN_PROMISES = "promises";
}