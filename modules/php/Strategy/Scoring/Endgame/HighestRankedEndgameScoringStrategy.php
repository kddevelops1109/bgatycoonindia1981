<?php
namespace Bga\Games\tycoonindianew\Strategy\Scoring\Endgame;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Type\Ranking;

class HighestRankedEndgameScoringStrategy extends RankedEndgameScoringStrategy {
  
  private function __construct(array $params) {
    parent::__construct($params);
    
    if ($this->ranking != Ranking::HIGHEST) {
      throw new InvalidArgumentException("Ranking must be highest for this strategy");
    }
  }

  /**
   * Apply tiered scoring strategy
   * @param int $playerId
   * @param string|array $counterNames
   * @param array<string|int, int> $reference
   * @throws InvalidArgumentException
   * @return void
   */
  public function evaluate(int $playerId, string|array $counterNames, array $reference): int {
    $score = 0;

    if (!array_key_exists(Ranking::HIGHEST->value, $reference)) {
      throw new InvalidArgumentException("Highest ranked endgame scoring strategy must have a score reference for Highest");
    }

    if ($this->ranking == Ranking::HIGHEST) {
      if (is_array($counterNames)) {
        // If there are multiple counters to evaluate, then take the highest among these counter values
        $highestValue = 0;
        foreach ($counterNames as $counterName) {
          $value = IndustrialistManager::getPlayerCounterValue($playerId, $counterName);
          if ($value > $highestValue) {
            $highestValue = $value;
          }
        }

        $score = $highestValue * $reference[Ranking::HIGHEST->value];
      }
      elseif (is_string($counterNames)) {
        // If single counter, then compare value with other players' values for it
        $value = IndustrialistManager::getPlayerCounterValue($playerId, $counterNames);
        $opponentPlayerIds = IndustrialistManager::getOpponentPlayerIds($playerId);

        $rank = 1;
        
        foreach ($opponentPlayerIds as $opponentPlayerId) {
          $opponentValue = IndustrialistManager::getPlayerCounterValue($opponentPlayerId, $counterNames);
          if ($opponentValue > $value) {
            $rank++;
            break;
          }
        }

        if ($rank == 1) {
          $score = $reference[Ranking::HIGHEST->value];
        }
      }
    }

    return $score;
  }
}