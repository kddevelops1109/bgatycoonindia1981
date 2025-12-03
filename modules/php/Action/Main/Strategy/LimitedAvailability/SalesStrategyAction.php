<?php
namespace Bga\Games\tycoonindianew\Action\Main\Strategy\LimitedAvailability;

use Bga\Games\tycoonindianew\Action\Main\StrategyAction;
use Bga\Games\tycoonindianew\Type\StrategyActionType as SAT;

class SalesStrategyAction extends StrategyAction {

  /**
   * Get type of strategy action
   * @return StrategyActionType
   */
  public function strategyActionType(): SAT {
    return SAT::SALES;
  }
}