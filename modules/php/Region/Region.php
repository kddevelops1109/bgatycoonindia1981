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
  protected RegionName $regionName;

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
   * Array of instances, one per region name
   * @var array<class-string, static>
   */
  private static array $instances = [];

  protected function __construct(RegionName $regionName) {
    $this->regionName = $regionName;
    $this->buildPlantBonus = $this->initBuildPlantBonus();
    $this->tycoonActivationBonus = $this->initTycoonActivationBonus();
  }

  /**
   * Returns instance of calling sub class
   * @return static
   */
  protected static function instance(RegionName $regionName): static {
    $className = static::class;
    if (!array_key_exists($className, self::$instances)) {
      self::$instances[$className] = new static($regionName);
    }

    return self::$instances[$className];
  }

  /**
   * Bonus players get on building a plant in this region
   * @return Effect
   */
  abstract protected function initBuildPlantBonus(): Effect;

  /**
   * Summary of tycoonActivationBonus
   * @return Effect
   */
  abstract protected function initTycoonActivationBonus(): Effect;

  /**
   * Apply the build plant bonus for this region
   * @param int $playerId
   * @return void
   */
  public function applyPlantBonus(int $playerId): void {
    $this->buildPlantBonus->apply($playerId);
  }
}