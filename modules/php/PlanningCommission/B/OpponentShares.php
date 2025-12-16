<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\B;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\PlanningCommission\PlanningCommissionCard;
use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\TopTwoRankedEndgameScoringStrategy;
use Bga\Games\tycoonindianew\Type\Ranking;

/**
 * Planning Commission giving players endgame influence based on number of opponent shares they have purchased
 */
class OpponentShares extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(TopTwoRankedEndgameScoringStrategy::instance(["ranking" => Ranking::TOP_TWO])->evaluate(
      $playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_SHARES_INVESTED, [Ranking::HIGHEST->value => 14, Ranking::SECOND_HIGHEST => 7]
    ));
  }

  /** Constants - Misc */
  const TYPE = "B";
  const NBR = 1;
  const NAME = "Opponent Shares";
  const DESCRIPTION = "Total Opponent Shares Bought by Player";
}