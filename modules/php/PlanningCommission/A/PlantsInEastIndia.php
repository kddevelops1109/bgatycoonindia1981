<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\A;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Model\Card\PlanningCommission\PlanningCommissionCard;

use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\TieredEndgameScoringStrategy;

use Bga\Games\tycoonindianew\Type\OperatorType;

class PlantsInEastIndia extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(TieredEndgameScoringStrategy::instance(["operator" => OperatorType::GREATER_THAN_EQUALS])->evaluate(
      $playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_PLANTS_IN_EAST_INDIA, self::INFLUENCE_REFERENCE)
    );
  }

  /** Constants - Misc */
  const TYPE = "A";
  const NAME = "Plants in East India";
  const DESCRIPTION = "Total Number of Plants in East Region";

  /** Constants - Reference */
  const INFLUENCE_REFERENCE = [
    1 => 2,
    2 => 5,
    3 => 10,
    4 => 14,
    5 => 18
  ];
}