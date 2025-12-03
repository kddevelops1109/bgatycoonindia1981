<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager;

use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\ExportStrategyActionSpace as ESAS;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class ExportStrategyMainActionManager extends StrategyMainActionManager {

  /**
   * Setup sales strategy action spaces
   * @return void
   */
  public function setupStrategyActionSpaces(): void {
    foreach ($this->getSpaceDefinitions() as $args) {
      // Create instance and persist it
      ESAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    return [
      ["cost" => SAS::generateCost(7), "reward" => SAS::generateReward(FT::SECTOR_PRODUCTION, 2), "index" => 1],
      ["cost" => SAS::generateCost(7), "reward" => SAS::generateReward(FT::SECTOR_PRODUCTION, 2), "index" => 2],
      ["cost" => SAS::generateCost(7), "reward" => SAS::generateReward(FT::SECTOR_PRODUCTION, 2), "index" => 3],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::SECTOR_PRODUCTION, 1), "index" => 1],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::SECTOR_PRODUCTION, 1), "index" => 2],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::SECTOR_PRODUCTION, 1), "index" => 3]
    ];
  }
}