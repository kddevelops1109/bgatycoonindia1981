<?php
namespace Bga\Games\tycoonindianew\Models;

use Bga\Games\tycoonindianew\Util\DataUtil;

/**
 * Represents an industrialist in the game, and a BGA player
 * @property int $id
 * @property int $no
 * @property string $name
 * @property string $color
 * @property string $colorName
 * @property bool $eliminated
 * @property int $score
 * @property int $scoreAux
 * @property bool $zombie
 * @property bool $isTycoon
 * @property bool $isNextTycoon
 */
class Industrialist extends DBObject {
  
  public function __construct($arr) {
    $this->table = self::TABLE_NAME;
    $this->primaryKey = self::dbFieldMappings()[self::COLUMN_PLAYER_ID];
    $this->dbFields = self::dbFieldMappings();
    $this->staticFields = self::staticFieldMappings();
    
    return parent::__construct($arr);
  }

  public static function dbFieldMappings() {
    return [
      self::COLUMN_PLAYER_ID => ["column" => self::COLUMN_PLAYER_ID, "name" => self::FIELD_PLAYER_ID, "type" => DataUtil::DATA_TYPE_INT, "readOnly" => true],
      self::COLUMN_PLAYER_NO => ["column" => self::COLUMN_PLAYER_NO, "name" => self::FIELD_PLAYER_NO, "type" => DataUtil::DATA_TYPE_INT, "readOnly" => true],
      self::COLUMN_PLAYER_NAME => ["column" => self::COLUMN_PLAYER_NAME, "name" => self::FIELD_PLAYER_NAME, "type" => DataUtil::DATA_TYPE_STRING, "readOnly" => true],
      self::COLUMN_PLAYER_COLOR => ["column" => self::COLUMN_PLAYER_COLOR, "name" => self::FIELD_PLAYER_COLOR, "type" => DataUtil::DATA_TYPE_STRING, "readOnly" => true],
      self::COLUMN_PLAYER_COLOR_NAME => ["column" => self::COLUMN_PLAYER_COLOR_NAME, "name" => self::FIELD_PLAYER_COLOR_NAME, "type" => DataUtil::DATA_TYPE_STRING, "readOnly" => false],
      self::COLUMN_PLAYER_ELIMINATED => ["column" => self::COLUMN_PLAYER_ELIMINATED, "name" => self::FIELD_PLAYER_ELIMINATED, "type" => DataUtil::DATA_TYPE_BOOL, "readOnly" => true],
      self::COLUMN_PLAYER_SCORE => ["column" => self::COLUMN_PLAYER_SCORE, "name" => self::FIELD_PLAYER_SCORE, "type" => DataUtil::DATA_TYPE_INT, "readOnly" => false],
      self::COLUMN_PLAYER_SCORE_AUX => ["column" => self::COLUMN_PLAYER_SCORE_AUX, "name" => self::FIELD_PLAYER_SCORE_AUX, "type" => DataUtil::DATA_TYPE_INT, "readOnly" => false],
      self::COLUMN_PLAYER_ZOMBIE => ["column" => self::COLUMN_PLAYER_ZOMBIE, "name" => self::FIELD_PLAYER_ZOMBIE, "type" => DataUtil::DATA_TYPE_BOOL, "readOnly" => false],
      self::COLUMN_PLAYER_IS_TYCOON => ["column" => self::COLUMN_PLAYER_IS_TYCOON, "name" => self::FIELD_PLAYER_IS_TYCOON, "type" => DataUtil::DATA_TYPE_BOOL, "readOnly" => false],
      self::COLUMN_PLAYER_IS_NEXT_TYCOON => ["column" => self::COLUMN_PLAYER_IS_NEXT_TYCOON, "name" => self::FIELD_PLAYER_IS_NEXT_TYCOON, "type" => DataUtil::DATA_TYPE_BOOL, "readOnly" => false]
    ];
  }

  public static function staticFieldMappings() {
    return [];
  }

  /** Constants - Misc */
  const TABLE_NAME = "player";

  /** Constants - DB Field names */
  const FIELD_PLAYER_ID = "id";
  const FIELD_PLAYER_NO = "no";
  const FIELD_PLAYER_NAME = "name";
  const FIELD_PLAYER_COLOR = "color";
  const FIELD_PLAYER_COLOR_NAME = "colorName";
  const FIELD_PLAYER_ELIMINATED = "eliminated";
  const FIELD_PLAYER_SCORE = "score";
  const FIELD_PLAYER_SCORE_AUX = "scoreAux";
  const FIELD_PLAYER_ZOMBIE = "zombie";
  const FIELD_PLAYER_IS_TYCOON = "isTycoon";
  const FIELD_PLAYER_IS_NEXT_TYCOON = "isNextTycoon";

  /** Constants - DB Columns */
  const COLUMN_PLAYER_ID = "player_id";
  const COLUMN_PLAYER_NO = "player_no";
  const COLUMN_PLAYER_NAME = "player_name";
  const COLUMN_PLAYER_COLOR = "player_color";
  const COLUMN_PLAYER_COLOR_NAME = "player_color_name";
  const COLUMN_PLAYER_ELIMINATED = "player_eliminated";
  const COLUMN_PLAYER_SCORE = "player_score";
  const COLUMN_PLAYER_SCORE_AUX = "player_score_aux";
  const COLUMN_PLAYER_ZOMBIE = "player_zombie";
  const COLUMN_PLAYER_IS_TYCOON = "player_is_tycoon";
  const COLUMN_PLAYER_IS_NEXT_TYCOON = "player_is_next_tycoon";
}