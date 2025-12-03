<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Action\Main\Strategy\LimitedAvailability\LobbyStrategyAction as LSA;
use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager as SAM;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\LobbyStrategyActionSpace as LSAS;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class LobbyStrategyMainActionManager extends SAM {

  /**
   * New game setup for this Strategy main action
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupStrategyActionSpaces();
  }

  /**
   * Setup sales strategy action spaces
   * @return void
   */
  public function setupStrategyActionSpaces(): void {
    foreach ($this->getSpaceDefinitions() as $args) {
      // Create instance and persist it
      LSAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    $action = LSA::instance(\clienttranslate("Discard 5 Promoters to gain any 1 open Policy card (from 2) of your choice, and place it near your player area. You own this Policy and all its bonuses/effects from now on. Gain any promoters on the Policy card if any. Reset back to 2 open Policy cards.
"));

    return [
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::POLICY, 1), "index" => 1, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::POLICY, 1), "index" => 2, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::POLICY, 1), "index" => 3, "action" => $action, "occupied" => false]
    ];
  }
}