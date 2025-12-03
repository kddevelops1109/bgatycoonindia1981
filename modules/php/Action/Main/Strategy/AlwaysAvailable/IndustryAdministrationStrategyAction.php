<?php
namespace Bga\Games\tycoonindianew\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Action\Main\Strategy\AlwaysAvailable\AdministrationStrategyAction;
use Bga\Games\tycoonindianew\Type\ActionSubType;

class IndustryAdministrationStrategyAction extends AdministrationStrategyAction {

  /**
   * Sub type of strategy action
   * @return ActionSubType
   */
  public function subType(): ActionSubType {
    return ActionSubType::ADMINISTRATION_BUY_INDUSTRY_CARD;
  }
}