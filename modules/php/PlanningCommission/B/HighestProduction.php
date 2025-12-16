<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\B;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\PlanningCommission\PlanningCommissionCard;
use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\HighestRankedEndgameScoringStrategy;
use Bga\Games\tycoonindianew\Type\Ranking;

class HighestProduction extends PlanningCommissionCard {

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

    return floatval(HighestRankedEndgameScoringStrategy::instance(["ranking" => Ranking::HIGHEST])->evaluate(
      $playerId, $counters, [Ranking::HIGHEST->value => 2]
    ));
  }

  /** Constants - Misc */
  const TYPE = "B";
  const NBR = 1;
  const NAME = "Highest Production";
  const DESCRIPTION = "Industrial Sector where Player has the Highest Production Level";
}