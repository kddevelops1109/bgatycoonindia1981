<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Action\Main\Strategy\LimitedAvailability\OfficeStrategyAction as OSA;
use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager as SAM;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\OfficeStrategyActionSpace as OSAS;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class OfficeStrategyMainActionManager extends SAM {

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
      OSAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    $action = OSA::instance(\clienttranslate("Discard 5 Promoters to add an unused available plant of your player color, to any empty city of your choice. Gain the Region and City bonus immediately. This plant acts as a regular plant on the map for all other purposes henceforth."));

    return [
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::PLANT, 1), "index" => 1, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::PLANT, 1), "index" => 2, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(5), "reward" => SAS::generateReward(FT::PLANT, 1), "index" => 3, "action" => $action, "occupied" => false]
    ];
  }
}