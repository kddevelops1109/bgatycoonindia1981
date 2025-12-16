<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\B;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\PlanningCommission\PlanningCommissionCard;
use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\TopTwoRankedEndgameScoringStrategy;
use Bga\Games\tycoonindianew\Type\Ranking;

class PromotersInPool extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(TopTwoRankedEndgameScoringStrategy::instance(["ranking" => Ranking::TOP_TWO])->evaluate(
      $playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_PROMOTERS_IN_POOL, [Ranking::HIGHEST->value => 15, Ranking::SECOND_HIGHEST => 7]
    ));
  }

  /** Constants - Misc */
  const TYPE = "B";
  const NAME = "Promoters in Pool";
  const DESCRIPTION = "Total Unused Promoters Remaining in Player's Strategy Pool";
}