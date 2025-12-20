<?php
namespace Bga\Games\tycoonindianew\Manager\Counters\Player;

use Bga\GameFramework\Components\Counters\PlayerCounter;

use Bga\Games\tycoonindianew\Game;
use Bga\Games\tycoonindianew\Manager\Counters\CounterManager;

abstract class PlayerCounterManager extends CounterManager {

  /**
   * Init db for given player counters
   * @param array $players
   * @param array<string> $counterNames
   * @return void
   */
  protected function initDbPlayerCounters(array $players, array $counterNames) {
    // Init db for all indicator player counters for all players to the min value
    foreach ($counterNames as $counterName) {
      $this->initCounter(array_keys($players), $counterName, $this->minValue($counterName));

      // Set the indicator counter values to the initial value for this counter each player
      foreach (array_keys($players) as $playerId) {
        $playerNo = Game::get()->getPlayerNoById($playerId);
        $initialValue = $this->initialValue($playerNo, $counterName);

        // Set counter value to the initial value
        $this->setCounterValue($playerId, $counterName, $initialValue);
      }
    }
  }

  /**
   * Initial value of player counter for given player
   * @param int $playerNo
   * @param string $counterName
   * @return int
   */
  abstract protected function initialValue(int $playerNo, string $counterName): int;
  
  /**
   * Init counter with given name with given initial value (default 0)
   * @param array $playerIds
   * @param string $counterName
   * @param int $initialValue
   * @return PlayerCounter
   */
  protected function initCounter(array $playerIds, string $counterName, int $initialValue = 0): PlayerCounter {
    $counter = Game::get()->counterFactory->createPlayerCounter($counterName);
    $counter->initDb($playerIds, $initialValue);
    
    $this->counters[$counterName] = $counter;

    return $counter;
  }

  /**
   * Get counter with given name. Returns null if not exists
   * @param string $counterName
   * @return PlayerCounter|null
   */
  protected function get(string $counterName): ?PlayerCounter {
    return array_key_exists($counterName, $this->counters) ? $this->counters[$counterName] : null;
  }

  /**
   * Get value of given counter for given player
   * @param int $playerId
   * @param string $counterName
   * @return int
   */
  protected function getCounterValue(int $playerId, string $counterName): int {
    $counter = $this->get($counterName);
    return $counter ? $counter->get($playerId) : -1;
  }

  /**
   * Set value of given counter to given value for given player
   * TODO: Add notification support
   * @param int $playerId
   * @param string $counterName
   * @param int $value
   * @return void
   */
  protected function setCounterValue(int $playerId, string $counterName, int $value) {
    $counter = $this->get($counterName);
    $counter->set($playerId, $value);
  }

  /**
   * Increment given counter (if exists). Return incremented value, if present
   * TODO: Add notification support
   * @param int $playerId
   * @param string $counterName
   * @param int $delta
   * @return int|null
   */
  protected function incCounterValue(int $playerId, string $counterName, int $delta = 1): ?int {
    $counter = $this->get($counterName);
    if ($counter != null) {
      $counter->inc($playerId, $delta);
    }

    return $counter ? $counter->get($playerId) : null;
  }

  /**
   * Decrement given counter (if exists). Return decremented value, if present
   * TODO: Add notification support
   * @param int $playerId
   * @param string $counterName
   * @param int $delta
   * @return int|null
   */
  protected function decCounterValue(int $playerId, string $counterName, int $delta = 1): ?int {
    return $this->incCounterValue($playerId, $counterName, 0 - $delta);
  }
}