<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\A;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Model\Card\PlanningCommission\PlanningCommissionCard;

use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\TieredEndgameScoringStrategy;

use Bga\Games\tycoonindianew\Type\OperatorType;

class ConnectedPlantsInSeries extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(TieredEndgameScoringStrategy::instance(["operator" => OperatorType::GREATER_THAN_EQUALS])->evaluate(
      $playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_CONNECTED_PLANTS_IN_SERIES, self::INFLUENCE_REFERENCE)
    );
  }

  /** Constants - Misc */
  const TYPE = "A";
  const NBR = 1;
  const NAME = "Connected Plants in Series";
  const DESCRIPTION = "Total Number of Plants Connected in Series";

  /** Constants - Reference */
  const INFLUENCE_REFERENCE = [
    2 => 6,
    3 => 9,
    4 => 12,
    5 => 15,
    6 => 19
  ];
}