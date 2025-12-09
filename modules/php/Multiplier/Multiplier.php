<?php
namespace Bga\Games\tycoonindianew\Multiplier;

/**
 * Represents a multiplier applied to an effect
 */
interface Multiplier {

  /**
   * Returns the value of this multiplier for this player
   * @param int $playerId
   * @return float
   */
  public function value(int $playerId): float;
}