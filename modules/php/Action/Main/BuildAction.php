<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionType as AT;

class BuildAction extends MainAction {

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::BUILD;
  }

  /** Constants - Misc */
  const DESCRIPTION = "Build an Industrial plant on any city on the Map. Pay the building costs to the leaders, and gain 4 bonuses.";
}