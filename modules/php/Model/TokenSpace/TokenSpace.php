<?php
namespace Bga\Games\tycoonindianew\Model\TokenSpace;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Contracts\Occupiable;
use Bga\Games\tycoonindianew\Contracts\Placeable;

use Bga\Games\tycoonindianew\Model\DBObject as DBO;
use Bga\Games\tycoonindianew\Model\Token\Token;

use Bga\Games\tycoonindianew\Type\DataType as DT;

/**
 * Represents a space that different tokens can occupy, such as action tokens in action spaces and strategy action spaces for player share tokens
 * @property string $spaceId Unique identifier of the space
 * @property ?Token $token Token occupying this space. In the database, this is the id of the token
 * @property bool $occupied Is this token space occupied?
 */
abstract class TokenSpace extends DBO implements Occupiable {

  public function __construct($args) {
    if (array_key_exists(self::FIELD_OCCUPIED, $args)) {
      $this->occupied = $args[self::FIELD_OCCUPIED];
    }

    parent::__construct($args);
  }
  
  /**
   * DB field mappings for all token spaces
   * @return array{column: string, name: string, readOnly: bool, type: DT[]}
   */
  public static function dbFieldMappings(): array {
    return [
      self::COLUMN_SPACE_ID => ["column" => self::COLUMN_SPACE_ID, "name" => self::FIELD_SPACE_ID, "type" => DT::STRING, "readOnly" => false],
      self::COLUMN_TOKEN => ["column" => self::COLUMN_TOKEN, "name" => self::FIELD_TOKEN, "type" => DT::INT, "readOnly" => false],
      self::COLUMN_OCCUPIED => ["column" => self::COLUMN_OCCUPIED, "name" => self::FIELD_OCCUPIED, "type" => DT::BOOL, "readOnly" => false]
    ];
  }

  public static function staticFieldsList(): array {
    return [];
  }

  /**
   * Generate space id for this token space
   * @param array|null $args
   * @return string
   */
  abstract public static function generateSpaceId(?array $args): string;


  /**
   * Place the given token in this token space
   * @param Placeable $placeable
   * @return void
   */
  public function occupy(Placeable $placeable) {
    if (!$placeable instanceof Token) {
      throw new InvalidArgumentException("TokenSpace accepts only Tokens");
    }

    $this->token = $placeable;
    $this->occupied = true;
  }
  
  /**
   * Token vacates this token space
   * @return void
   */
  public function vacate() {
    $this->token = null;
    $this->occupied = false;
  }

  /**
   * Constants - DB Columns
   */
  const COLUMN_SPACE_ID = "space_id";
  const COLUMN_TOKEN = "token";
  const COLUMN_OCCUPIED = "occupied";

  /**
   * Constants - Fields
   */
  const FIELD_SPACE_ID = "spaceId";
  const FIELD_TOKEN = "token";
  const FIELD_OCCUPIED = "occupied";
}