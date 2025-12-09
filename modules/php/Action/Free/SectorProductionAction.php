<?php
namespace Bga\Games\tycoonindianew\Action\Free;

use Bga\Games\tycoonindianew\Type\ActionExecution as AE;
use Bga\Games\tycoonindianew\Type\ActionType as AT;

class SectorProductionAction extends FreeAction {

  /**
   * Sector production action is manual as player needs to choose which sector to increase production in
   * @return AE
   */
  public function actionExecution(): AE {
    return AE::MANUAL;
  }

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::SECTOR_PRODUCTION;
  }

  /** Constants - Misc */
  const DESCRIPTION = "Increase one of your sector productions by 1";
}