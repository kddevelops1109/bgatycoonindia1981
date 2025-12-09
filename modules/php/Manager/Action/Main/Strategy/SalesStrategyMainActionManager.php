<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Action\Main\Strategy\LimitedAvailability\SalesStrategyAction as SSA;
use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager as SAM;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\SalesStrategyActionSpace as SSAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class SalesStrategyMainActionManager extends SAM {

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
      SSAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    $action = SSA::instance(\clienttranslate("Discard 3 or 4 Promoters to gain specified Money from the general supply."));

    return [
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::MONEY, 40, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::MONEY, 35, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::MONEY, 30, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(3), "reward" => SAS::generateReward(FT::MONEY, 30, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(3), "reward" => SAS::generateReward(FT::MONEY, 25, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(3), "reward" => SAS::generateReward(FT::MONEY, 20, null), "action" => $action, "occupied" => false]
    ];
  }
}