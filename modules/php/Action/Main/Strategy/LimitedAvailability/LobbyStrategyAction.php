<?php
namespace Bga\Games\tycoonindianew\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Action\Main\StrategyAction;
use Bga\Games\tycoonindianew\Type\StrategyActionType;

class LobbyStrategyAction extends StrategyAction {

  /**
   * Get type of strategy action
   * @return StrategyActionType
   */
  public function strategyActionType(): StrategyActionType {
    return StrategyActionType::LOBBY;
  }
}