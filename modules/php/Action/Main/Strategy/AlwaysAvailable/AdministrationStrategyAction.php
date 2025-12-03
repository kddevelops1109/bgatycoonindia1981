<?php
namespace Bga\Games\tycoonindianew\Action\Main\Strategy\AlwaysAvailable;

use Bga\Games\tycoonindianew\Type\StrategyActionType as SAT;

abstract class AdministrationStrategyAction extends AlwaysAvailableStrategyAction {

  /**
   * Get type of strategy action
   * @return StrategyActionType
   */
  public function strategyActionType(): SAT {
    return SAT::ADMINISTRATION;
  }
}