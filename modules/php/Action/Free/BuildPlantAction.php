<?php
namespace Bga\Games\tycoonindianew\Action\Free;

use Bga\Games\tycoonindianew\Type\ActionExecution as AE;
use Bga\Games\tycoonindianew\Type\ActionType as AT;

class BuildPlantAction extends FreeAction {

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
    return AT::BUILD_PLANT;
  }

  /** Constants - Misc */
  const DESCRIPTION = "Build a plant in an unoccupied city of your choice";
}