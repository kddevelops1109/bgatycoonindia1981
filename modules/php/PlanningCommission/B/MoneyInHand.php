<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\B;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\PlanningCommission\PlanningCommissionCard;
use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\TopTwoRankedEndgameScoringStrategy;
use Bga\Games\tycoonindianew\Type\Ranking;

class MoneyInHand extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(TopTwoRankedEndgameScoringStrategy::instance(["ranking" => Ranking::TOP_TWO])->evaluate(
      $playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_MONEY, [Ranking::HIGHEST->value => 14, Ranking::SECOND_HIGHEST => 7]
    ));
  }

  /** Constants - Misc */
  const TYPE = "B";
  const NBR = 1;
  const NAME = "Money in Hand";
  const DESCRIPTION = "Total Unused Money Remaining in Player's Hand";
}