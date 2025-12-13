<?php
namespace Bga\Games\tycoonindianew\Model\Card\PlanningCommission;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Model\Card\Card;

/**
 * Represents a planning commission card (A/B)
 * @property string $type Type of planning commission, i.e. A or B
 * @property string $description Description of the planning commission
 * @property Effect $endgameInfluence Endgame influence given by the planning commission
 */
abstract class PlanningCommissionCard extends Card {

  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      ...[
        self::FIELD_TYPE => static::TYPE,
        self::FIELD_DESCRIPTION => static::DESCRIPTION
      ]
    ];
  }

  /**
   * Obtain the endgame influence multiplier for the specific planning commission
   * @param int $playerId
   * @return float
   */
  abstract public function obtainEndgameInfluenceMultiplier(int $playerId): float;

  /**
   * Planning commissions cannot be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return false;
  }

  /**
   * Planning commissions cannot be lost
   * @return bool
   */
  public function canBeLost(): bool {
    return false;
  }

  /**
   * Constants - Filepath and Classpath
   */
  const FILEPATH_A = "/../../PlanningCommission/A/list.inc.php";
  const FILEPATH_B = "/../../PlanningCommission/B/list.inc.php";
  const CLASSPATH_A = "\Bga\Games\\tycoonindianew\PlanningCommission\A";
  const CLASSPATH_B = "\Bga\Games\\tycoonindianew\PlanningCommission\B";

  /** Constants - Field names */
  const FIELD_TYPE = "type";
  const FIELD_DESCRIPTION = "description";

  /** Constants - Misc */
  const NBR = 1;
}