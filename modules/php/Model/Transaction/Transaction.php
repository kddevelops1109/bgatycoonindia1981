<?php
namespace Bga\Games\tycoonindianew\Model\Transaction;

use Bga\Games\tycoonindianew\Model\DBObject as DBO;
use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Transaction impacting industrialist(s) or between industrialists
 * @property string $id
 * @property string $state
 * @property int $round
 * @property string $details
 * @property array $promises
 */
class Transaction extends DBO {

  protected function __construct($args) {
    $this->dbFields = self::dbFieldMappings();

    if (!array_key_exists(self::FIELD_ID, $args)) {
      $args[self::FIELD_ID] = StringUtil::uuid();
    }

    parent::__construct($args);
  }

  /**
   * DB field mappings for transactions
   * @return array<array|mixed>
   */
  public static function dbFieldMappings(): array {
    return [
      ...parent::dbFieldMappings(),
      ...[
        self::COLUMN_ID => ["column" => self::COLUMN_ID, "name" => self::FIELD_ID, "type" => DT::STRING, "readOnly" => false],
        self::COLUMN_STATE => ["column" => self::COLUMN_STATE, "name" => self::FIELD_STATE, "type" => DT::STRING, "readOnly" => false],
        self::COLUMN_ROUND => ["column" => self::COLUMN_ROUND, "name" => self::FIELD_ROUND, "type" => DT::INT, "readOnly" => false],
        self::COLUMN_DETAILS => ["column" => self::COLUMN_DETAILS, "name" => self::FIELD_DETAILS, "type" => DT::STRING, "readOnly" => false],
        self::COLUMN_PROMISES => ["column" => self::COLUMN_PROMISES, "name" => self::FIELD_PROMISES, "type" => DT::OBJ, "readOnly" => false]
      ]
    ];
  }

  /**
   * Static fields list for transactions
   * @return array
   */
  public static function staticFieldsList(): array {
    return [...parent::staticFieldsList(), ...[]];
  }

  /**
   * Static field args for transactions
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [...parent::staticFieldArgs(), ...[]];
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