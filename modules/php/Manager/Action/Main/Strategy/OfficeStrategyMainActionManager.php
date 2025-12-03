<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager;

use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\OfficeStrategyActionSpace as OSAS;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class OfficeStrategyMainActionManager extends StrategyMainActionManager {

  /**
   * Setup sales strategy action spaces
   * @return void
   */
  public function setupStrategyActionSpaces(): void {
    foreach ($this->getSpaceDefinitions() as $args) {
      // Create instance and persist it
      OSAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    return [
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::PLANT, 1), "index" => 1],
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::PLANT, 1), "index" => 2],
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::PLANT, 1), "index" => 3]
    ];
  }
}