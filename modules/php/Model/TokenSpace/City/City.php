<?php
namespace Bga\Games\tycoonindianew\Model\TokenSpace\City;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\TokenSpace\TokenSpace;

use Bga\Games\tycoonindianew\Region\Region;

use Bga\Games\tycoonindianew\Type\CityName;
use Bga\Games\tycoonindianew\Type\DataType as DT;

/**
 * City on the main board that holds built plants
 * @property CityName $name Name of the city
 * @property Region $region Region to which the city belongs
 * @property Effect $bonus Bonus given by the city
 * @property bool $isRegionalMetro Indicates if the city is its region's metro city or not
 * @property ?int $playerId ID of the player whose plant has been built here, if any
 */
abstract class City extends TokenSpace {

  /**
   * Array of instances, one per city
   * @var array<class-string, static>
   */
  private static array $instances = [];

  protected function __construct(array $args, CityName $name, Region $region, bool $isRegionalMetro = false) {
    $this->initBonus();
    $args = [
      ...$args,
      ...[self::FIELD_NAME => $name,self::FIELD_REGION => $region, self::FIELD_IS_REGIONAL_METRO => $isRegionalMetro]
    ];

    $fieldName = self::FIELD_SPACE_ID;
    $this->$fieldName = static::generateSpaceId($args);

    parent::__construct($args);
  }

  /**
   * Returns an instance of this city
   * @param CityName $name
   * @param Region $region
   * @return City
   */
  protected static function instance(array $args, CityName $name, Region $region, bool $isRegionalMetro = false): static {
    $className = static::class;
    if (!array_key_exists($className, self::$instances)) {
      self::$instances[$className] = new static($args, $name, $region, $isRegionalMetro);
    }

    return self::$instances[$className];
  }

  /**
   * Get or create specific city instance
   * @param array $args
   * @return static
   */
  abstract public static function getOrCreate(array $args): static;

  /**
   * Get instance of specific city
   * @return static
   */
  public static function get(): static {
    $className = static::class;
    return self::$instances[$className];
  }

  public static function dbFieldMappings(): array {
    return [
      ...parent::dbFieldMappings(),
      ...[
        self::COLUMN_PLAYER_ID => ["column" => self::COLUMN_PLAYER_ID, "name" => self::FIELD_PLAYER_ID, "type" => DT::INT, "readOnly" => false]
      ]
    ];
  }
  
  public static function staticFieldsList(): array {
    return [
      ...parent::staticFieldsList(),
      ...[self::FIELD_NAME, self:: FIELD_REGION, self::FIELD_BONUS, self::FIELD_IS_REGIONAL_METRO]
    ];
  }

  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      ...[
        self::FIELD_NAME => static::NAME,
        self::FIELD_REGION => static::REGION,
        self::FIELD_BONUS => static::bonus(),
        self::FIELD_IS_REGIONAL_METRO => static::isRegionalMetro()
      ]
    ];
  }

  /**
   * Returns the city's bonus
   * @return Effect
   */
  abstract protected static function bonus(): Effect;

  /**
   * City that lies before this one in the map
   * @return City
   */
  abstract public function before(): City;
  
  /**
   * City that lies after this one in the map
   * @return City
   */
  abstract public function after(): City;

  /**
   * Return false by default, unless updated in static sub class
   * @return bool
   */
  public static function isRegionalMetro(): bool {
    return false;
  }

  /** Constants - Misc */
  const TABLE_NAME = "tycoon_city";

  /** Constants - Field names */
  const FIELD_NAME = "name";
  const FIELD_BONUS = "bonus";
  const FIELD_REGION = "region";
  const FIELD_IS_REGIONAL_METRO = "isRegionalMetro";
  const FIELD_PLAYER_ID = "playerId";

  /** Constants - DB Column names */
  const COLUMN_PLAYER_ID = "player_id";
}