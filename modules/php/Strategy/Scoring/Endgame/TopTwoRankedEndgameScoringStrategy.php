<?php
namespace Bga\Games\tycoonindianew\Strategy\Scoring\Endgame;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Type\Ranking;

class TopTwoRankedEndgameScoringStrategy extends RankedEndgameScoringStrategy {
  
  private function __construct(array $params) {
    parent::__construct($params);
    
    if ($this->ranking != Ranking::TOP_TWO) {
      throw new InvalidArgumentException("Ranking must be top two for this strategy");
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

    if ($this->ranking == Ranking::TOP_TWO) {
      if (is_array($counterNames)) {
        throw new InvalidArgumentException("Array of counters not supported for top two scoring strategy");
      }

      $actualValue = IndustrialistManager::getPlayerCounterValue($playerId, $counterNames);
      $rank = 1;
      foreach (IndustrialistManager::getOpponentPlayerIds($playerId) as $opponentPlayerId) {
        $opponentValue = IndustrialistManager::getPlayerCounterValue($opponentPlayerId, $counterNames);
        if ($opponentValue > $actualValue) {
          $rank++;
        }
      }

      if ($rank == 1) {
        $score = $reference[Ranking::HIGHEST->value];
      }
      elseif ($rank == 2) {
        $score = $reference[Ranking::SECOND_HIGHEST->value];
      }
    }

    return $score;
  }
}