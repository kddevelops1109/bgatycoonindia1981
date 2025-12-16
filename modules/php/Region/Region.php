<?php
namespace Bga\Games\tycoonindianew\Region;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Type\RegionName;

/**
 * Represents one of the four regions in the game, i.e. North, East, West and South
 */
abstract class Region {

  /**
   * Name of the region (one of North, East, West or South)
   * @var RegionName
   */
  protected RegionName $name;

  /**
   * Bonus players get on building a plant in this region
   * @var Effect
   */
  protected Effect $buildPlantBonus;

  /**
   * Bonus players get during tycoon region activation, due to their plants in this region
   * @var Effect
   */
  protected Effect $tycoonActivationBonus;

  /**
   * Array of instances, one per region
   * @var array<class-string, static>
   */
  private static array $instances = [];

  protected function __construct(RegionName $name) {
    $this->name = $name;
    $this->initBuildPlantBonus();
    $this->initTycoonActivationBonus();
  }

  /**
   * Returns instance of calling sub class
   * @return static
   */
  protected static function instance(RegionName $name): static {
    $className = static::class;
    if (!array_key_exists($className, self::$instances)) {
      self::$instances[$className] = new static($name);
    }

    return self::$instances[$className];
  }

  /**
   * Bonus players get on building a plant in this region
   */
  abstract protected function initBuildPlantBonus(): void;

  /**
   * Summary of tycoonActivationBonus
   */
  abstract protected function initTycoonActivationBonus(): void;

  /**
   * Apply the build plant bonus for this region
   * @param int $playerId
   * @return void
   */
  public function applyPlantBonus(int $playerId): void {
    $this->buildPlantBonus->apply($playerId);
  }
}