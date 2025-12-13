<?php
namespace Bga\Games\tycoonindianew\PlanningCommission\A;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Model\Card\PlanningCommission\PlanningCommissionCard;

use Bga\Games\tycoonindianew\Strategy\Scoring\Endgame\TieredEndgameScoringStrategy;

use Bga\Games\tycoonindianew\Type\OperatorType;

class PlantsInNorthIndia extends PlanningCommissionCard {

  /**
   * Endgame influence multiplier for this planning commission
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(TieredEndgameScoringStrategy::instance(["operator" => OperatorType::GREATER_THAN_EQUALS])->evaluate(
      $playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_PLANTS_IN_NORTH_INDIA, self::INFLUENCE_REFERENCE)
    );
  }

  /** Constants - Misc */
  const TYPE = "A";
  const NBR = 1;
  const NAME = "Plants in North India";
  const DESCRIPTION = "Total Number of Plants in North Region";

  /** Constants - Reference */
  const INFLUENCE_REFERENCE = [
    1 => 2,
    2 => 4,
    3 => 7,
    4 => 11,
    5 => 17
  ];
}