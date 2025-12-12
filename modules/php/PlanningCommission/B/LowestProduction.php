<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\B;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\PlanningCommission\PlanningCommissionCard;
use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\LowestRankedEndgameScoringStrategy;
use Bga\Games\tycoonindianew\Type\Ranking;

class LowestProduction extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    $counters = [
      IndustrialistManager::COUNTER_INDUSTRIALIST_FINANCE,
      IndustrialistManager::COUNTER_INDUSTRIALIST_MINERALS,
      IndustrialistManager::COUNTER_INDUSTRIALIST_FUEL,
      IndustrialistManager::COUNTER_INDUSTRIALIST_AGRO,
      IndustrialistManager::COUNTER_INDUSTRIALIST_POWER,
      IndustrialistManager::COUNTER_INDUSTRIALIST_TRANSPORT
    ];

    return floatval(LowestRankedEndgameScoringStrategy::instance(["ranking" => Ranking::LOWEST])->evaluate(
      $playerId, $counters, [Ranking::LOWEST->value => 2]
    ));
  }

  /** Constants - Misc */
  const TYPE = "B";
  const NAME = "Lowest Production";
  const DESCRIPTION = "Industrial Sector where Player has the Lowest Production Level";
}