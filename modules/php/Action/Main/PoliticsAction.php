<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionSubType;
use Bga\Games\tycoonindianew\Type\ActionType;

class PoliticsAction extends MainAction {

  /**
   * Type of action
   * @return ActionType
   */
  public function actionType(): ActionType {
    return ActionType::POLITICS;
  }

  /**
   * Sub type of action
   * @return ActionSubType
   */
  public function subType(): ActionSubType {
    return ActionSubType::NOT_APPLICABLE;
  }
}