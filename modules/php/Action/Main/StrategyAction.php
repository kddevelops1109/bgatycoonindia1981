<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionSubType;
use Bga\Games\tycoonindianew\Type\ActionType;
use Bga\Games\tycoonindianew\Type\StrategyActionType;

abstract class StrategyAction extends MainAction {

  /**
   * Type of action
   * @return ActionType
   */
  public function actionType(): ActionType {
    return ActionType::BUILD;
  }

  /**
   * Returns the specific strategy action type for this strategy action
   * @return void
   */
  abstract public function strategyActionType(): StrategyActionType;
}