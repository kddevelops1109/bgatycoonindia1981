<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionSubType;
use Bga\Games\tycoonindianew\Type\ActionType;

class BuildAction extends MainAction {

  /**
   * Type of action
   * @return ActionType
   */
  public function actionType(): ActionType {
    return ActionType::BUILD;
  }
}