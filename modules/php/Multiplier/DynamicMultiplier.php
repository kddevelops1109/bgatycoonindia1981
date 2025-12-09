<?php
namespace Bga\Games\tycoonindianew\Multiplier;

/**
 * Provides a dynamic value for the multiplier determined by the callback function
 * @property callable $callback
 */
class DynamicMultiplier implements Multiplier {

  /**
   * Callback function to determine the value of this multiplier
   * @var callable
   */
  private $callback;

  public function __construct(callable $callback) {
    $this->callback = $callback;
  }

  public function value(int $playerId): float {
    return floatval(($this->callback)($playerId));
  }
}