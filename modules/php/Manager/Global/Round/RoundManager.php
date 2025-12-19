<?php
namespace Bga\Games\tycoonindianew\Manager\Global\Round;

use Bga\GameFramework\Components\Counters\TableCounter;
use Bga\Games\tycoonindianew\Game;
use Bga\Games\tycoonindianew\Manager\Global\TableCounterManager;
use Bga\Games\tycoonindianew\Type\TableCounters;

class RoundManager extends TableCounterManager {

  /**
   * New game setup of round marker and round marker spaces
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->initDb();    
  }

  /**
   * Define init of round counter
   * @return void
   */
  public function initDb(){
    $this->initCounter(TableCounters::COUNTER_ROUND_MARKER->value, $this->minValue(TableCounters::COUNTER_ROUND_MARKER->value));
  }

  /**
   * Min value of round
   * @param $counterName
   * @return int
   */
  public function minValue(string $counterName): int {
    // Always return 0. Counter name argument is redundant here, as the round manager caters to just one counter, i.e. the round marker
    return 0;
  }

  /**
   * Max value of round
   * @param $counterName
   * @return int
   */
  public function maxValue(string $counterName): int {
    // Always return 8. Counter name argument is redundant here, as the round manager caters to just one counter, i.e. the round marker
    return 8;
  }

  /**
   * Proceed to next round. Start by incrementing the round marker (as long as it is not already at max)
   * @return void
   */
  public function next() {
    // Increment round counter by 1
    $counterName = TableCounters::COUNTER_ROUND_MARKER->value;

    $round_marker = $this->getCounterValue($counterName);
    if ($round_marker < $this->maxValue($counterName)) {
      $this->incCounterValue($counterName);
    }

    // TODO: Implement other round progress updates, if any, depending on which round
  }
}