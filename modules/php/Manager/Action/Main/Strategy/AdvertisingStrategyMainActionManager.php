<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager;

use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\AdvertisingStrategyActionSpace as ASAS;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class AdvertisingStrategyMainActionManager extends StrategyMainActionManager {

  /**
   * Setup sales strategy action spaces
   * @return void
   */
  public function setupStrategyActionSpaces(): void {
    foreach ($this->getSpaceDefinitions() as $args) {
      // Create instance and persist it
      ASAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    return [
      ["cost" => SAS::generateCost(6), "reward" => SAS::generateReward(FT::INFLUENCE, 9)],
      ["cost" => SAS::generateCost(6), "reward" => SAS::generateReward(FT::INFLUENCE, 8)],
      ["cost" => SAS::generateCost(6), "reward" => SAS::generateReward(FT::INFLUENCE, 7)],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::INFLUENCE, 7)],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::INFLUENCE, 6)],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::INFLUENCE, 5)]
    ];
  }
}