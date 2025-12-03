<?php
namespace Bga\Games\tycoonindianew\Model\Card\PlanningCommission;

use Bga\Games\tycoonindianew\Model\Card\Card;

abstract class PlanningCommissionCard extends Card {

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
  const FILEPATH = "/../../PlanningCommission/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\PlanningCommission";
}