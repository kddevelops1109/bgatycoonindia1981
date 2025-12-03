<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\SalesStrategyActionSpace as SSAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use BgaVisibleSystemException;

class SalesStrategyMainActionManager extends StrategyMainActionManager {

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
    return [
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::MONEY, 40)],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::MONEY, 35)],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::MONEY, 30)],
      ["cost" => SAS::generateCost(3), "reward" => SAS::generateReward(FT::MONEY, 30)],
      ["cost" => SAS::generateCost(3), "reward" => SAS::generateReward(FT::MONEY, 25)],
      ["cost" => SAS::generateCost(3), "reward" => SAS::generateReward(FT::MONEY, 20)]
    ];
  }
}