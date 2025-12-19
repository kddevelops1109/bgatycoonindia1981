<?php
namespace Bga\Games\tycoonindianew\Manager\Counters;

use Bga\GameFramework\Components\Counters\PlayerCounter;
use Bga\GameFramework\Components\Counters\TableCounter;

use Bga\Games\tycoonindianew\Manager\Manager;

abstract class CounterManager implements Manager {

  /**
   * Player/table counters
   * @var array<string, PlayerCounter|TableCounter>
   */
  protected array $counters = [];

  /**
   * Static instances
   * @var array<class-string, static>
   */
  private static array $instances = [];

  private function __construct() {
    // Private constructor - can only be called by instance method
  }

  public static function instance(): static {
    $className = static::class;
    if (!array_key_exists($className, self::$instances)) {
      self::$instances[$className] = new static();
    }

    return self::$instances[$className];
  }

  /**
   * Define init of specific counter(s)
   * @return void
   */
  abstract protected function initDb();

  /**
   * Min value of table/player counter
   * @param $counterName
   * @return int
   */
  abstract protected function minValue(string $counterName): int;

  /**
   * Max value of table/player counter
   * @param $counterName
   * @return int
   */
  abstract protected function maxValue(string $counterName): int;
}