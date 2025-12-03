<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionType as AT;
use Bga\Games\tycoonindianew\Type\StrategyActionType as SAT;

class StrategyAction extends MainAction {

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::STRATEGY;
  }

  /**
   * Returns the specific strategy action type for this strategy action
   * @return SAT
   */
  public function strategyActionType(): SAT {
    return SAT::STRATEGY;
  }
}