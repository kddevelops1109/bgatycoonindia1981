<?php
namespace Bga\Games\tycoonindianew\Trigger;

use Bga\Games\tycoonindianew\Model\DBObject as DBO;

use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\TriggerState;

use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Represents a game trigger
 * @property string $id ID of the trigger
 * @property string $key Key corresponding to the definition of the trigger
 * @property int $playerId ID of the player
 * @property TriggerState $state State of the trigger (AWAITING_TRIGGER/TRIGGERED)
 */
class Trigger extends DBO {

  public function __construct($args) {
    $this->primaryKey = self::dbFieldMappings()[self::COLUMN_ID];
    if (!array_key_exists(self::FIELD_ID, $args)) {
      $this->id = StringUtil::uuid();
    }

    parent::__construct($args);
  }

  public static function dbFieldMappings() {
    return [
      self::COLUMN_ID => ["name" => self::FIELD_ID, "type" => DT::STRING, "column" => self::COLUMN_ID, "readOnly" => true],
      self::COLUMN_KEY => ["name" => self::FIELD_KEY, "type" => DT::STRING, "column" => self::COLUMN_KEY, "readOnly" => false],
      self::COLUMN_PLAYER_ID => ["name" => self::FIELD_PLAYER_ID, "type" => DT::INT, "column" => self::COLUMN_PLAYER_ID, "readOnly" => false],
      self::COLUMN_STATE => ["name" => self::FIELD_STATE, "type" => DT::STRING, "column" => self::COLUMN_STATE, "readOnly" => false]
    ];
  }

  /**
   * Fire this trigger
   * @return void
   */
  public function fire() {
    TriggerDefinition::get($this->key)->target->fire($this->playerId);
  }

  /** Constants - Misc */
  const TABLE_NAME = "tycoon_trigger";

  /** Constants - Field names */
  const FIELD_ID = "id";
  const FIELD_KEY = "key";
  const FIELD_PLAYER_ID = "playerId";
  const FIELD_STATE = "state";

  /** Constants - DB columns */
  const COLUMN_ID = "id";
  const COLUMN_KEY = "key";
  const COLUMN_PLAYER_ID = "player_id";
  const COLUMN_STATE = "state";
}