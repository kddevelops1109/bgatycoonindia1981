<?php
namespace Bga\Games\tycoonindianew\Model\TokenSpace\Action;

use Bga\Games\tycoonindianew\Action\Action;
use Bga\Games\tycoonindianew\Model\TokenSpace\TokenSpace;
use Bga\Games\tycoonindianew\Type\DataType as DT;

/**
 * Represents action spaces for action tokens
 * @property Action $action Action that was taken for a token to occupy this space
 * @property ?int $playerId ID of the player whose action led to a token occupying this space 
 */
abstract class ActionSpace extends TokenSpace {
  
  public static function dbFieldMappings(): array {
    return [...parent::dbFieldMappings(), ...[self::COLUMN_PLAYER_ID => ["column" => self::COLUMN_PLAYER_ID, "name" => self::FIELD_PLAYER_ID, "type" => DT::INT, "readOnly" => false]]];
  }

  public static function staticFieldsList(): array {
    return [...parent::staticFieldsList(), ...[self::FIELD_ACTION]];
  }

  /**
   * Constants - DB Columns
   */
  const COLUMN_PLAYER_ID = "player_id";

  /**
   * Constants - Fields
   */
  const FIELD_ACTION = "action";
  const FIELD_PLAYER_ID = "playerId";
}