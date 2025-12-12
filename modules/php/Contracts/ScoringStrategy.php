<?php
namespace Bga\Games\tycoonindianew\Contracts;

interface ScoringStrategy {

  /**
   * Apply strategy for given player and return score
   * @param int $playerId ID of player for whom this scoring strategy is being used
   * @param string|array<string> $counterNames Name(s) of counters to use
   * @param array<string|int, int> $reference Reference array for scoring
   * @return int
   */
  public function evaluate(int $playerId, string|array $counterNames, array $reference): int;
}