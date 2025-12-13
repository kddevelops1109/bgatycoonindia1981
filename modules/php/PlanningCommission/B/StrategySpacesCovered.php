<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\B;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\PlanningCommission\PlanningCommissionCard;
use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\TopTwoRankedEndgameScoringStrategy;
use Bga\Games\tycoonindianew\Type\Ranking;

class StrategySpacesCovered extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(TopTwoRankedEndgameScoringStrategy::instance(["ranking" => Ranking::TOP_TWO])->evaluate(
      $playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_STRATEGY_SPACES_COVERED, [Ranking::HIGHEST->value => 13, Ranking::SECOND_HIGHEST => 6]
    ));
  }

  /** Constants - Misc */
  const TYPE = "B";
  const NBR = 1;
  const NAME = "Strategy Spaces Covered";
  const DESCRIPTION = "Total Number of Strategy Spaces Occupied by Player";
}