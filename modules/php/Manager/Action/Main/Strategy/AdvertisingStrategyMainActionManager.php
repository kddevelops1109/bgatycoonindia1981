<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Action\Main\Strategy\LimitedAvailability\AdvertisingStrategyAction as ASA;
use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager as SAM;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\AdvertisingStrategyActionSpace as ASAS;

use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class AdvertisingStrategyMainActionManager extends SAM {

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
      ASAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    $action = ASA::instance(\clienttranslate("Discard 4 or 6 Promoters to gain specified Influence. Move up on the Influence track."));

    return [
      ["cost" => SAS::generateCost(6), "reward" => SAS::generateReward(FT::INFLUENCE, 9, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(6), "reward" => SAS::generateReward(FT::INFLUENCE, 8, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(6), "reward" => SAS::generateReward(FT::INFLUENCE, 7, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::INFLUENCE, 7, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::INFLUENCE, 6, null), "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::INFLUENCE, 5, null), "action" => $action, "occupied" => false]
    ];
  }
}