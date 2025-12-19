<?php
namespace Bga\Games\tycoonindianew\Manager\Global;

use Bga\GameFramework\Components\Counters\TableCounter;
use Bga\Games\tycoonindianew\Game;
use Bga\Games\tycoonindianew\Manager\Manager;

abstract class TableCounterManager implements Manager {

  /**
   * Global counters
   * @var array<string, TableCounter>
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
   * Min value of table counter
   * @param $counterName
   * @return int
   */
  abstract protected function minValue(string $counterName): int;

  /**
   * Max value of table counter
   * @param $counterName
   * @return int
   */
  abstract protected function maxValue(string $counterName): int;

  /**
   * Init counter with given name with given initial value (default 0)
   * @param string $counterName
   * @param int $initialValue
   * @return TableCounter
   */
  protected function initCounter(string $counterName, int $initialValue = 0): TableCounter {
    $counter = Game::get()->counterFactory->createTableCounter($counterName);
    $counter->initDb($initialValue);
    
    $this->counters[$counterName] = $counter;

    return $counter;
  }

  /**
   * Get or init counter with given name. Init to given initial value (default 0), if counter does not exist
   * @param string $counterName
   * @param int $initialValue
   * @return TableCounter|null
   */
  protected function getOrInit(string $counterName, bool $bInit = true, int $initialValue = 0): ?TableCounter {
    $counter = array_key_exists($counterName, $this->counters) ? $this->counters[$counterName] : null;
    if ($counter == null && $bInit) {
      $counter = $this->initCounter($counterName, $initialValue);
      $this->counters[$counterName] = $counter;
    }

    return $counter;
  }

  /**
   * Get value of given counter.
   * If init is set to true, and the counter does not exist, it will create and init a new counter to 0, and return its value.
   * If init is set to false, and the counter does not exist, it will return -1 (indicating that the counter does not exist)
   * @param string $counterName
   * @param bool $init
   * @return int
   */
  protected function getCounterValue(string $counterName, bool $bInit = false): int {
    $counter = $this->getOrInit($counterName, $bInit);
    return $counter ? $counter->get() : -1;
  }

  /**
   * Set value of given counter to given value.
   * TODO: Add notification support
   * @param string $counterName
   * @param int $value
   * @return void
   */
  protected function setCounterValue(string $counterName, int $value) {
    $counter = $this->getOrInit($counterName, true, $value);
    $counter->set($value);
  }

  /**
   * Increment given counter (if exists). Init if counter does not exist and function call asks to.
   * Return incremented value, if present
   * TODO: Add notification support
   * @param string $counterName
   * @param int $delta
   * @param bool $bInit
   * @return int|null
   */
  protected function incCounterValue(string $counterName, int $delta = 1, bool $bInit = false): ?int {
    $counter = $this->getOrInit($counterName, $bInit);
    if ($counter != null) {
      $counter->inc($delta);
    }

    return $counter ? $counter->get() : null;
  }

  /**
   * Increment given counter (if exists). Init if counter does not exist and function call asks to.
   * Return incremented value, if present
   * TODO: Add notification support
   * @param string $counterName
   * @param int $delta
   * @param bool $bInit
   * @return int|null
   */
  protected function decCounterValue(string $counterName, int $delta = 1, bool $bInit = false): ?int {
    return $this->incCounterValue($counterName, 0 - $delta, $bInit);
  }
}