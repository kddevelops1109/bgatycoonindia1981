<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Action\Free\SectorProductionAction;
use Bga\Games\tycoonindianew\Action\Main\Strategy\LimitedAvailability\ExportStrategyAction as ESA;
use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager as SAM;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\StrategyActionSpace as SAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Strategy\ExportStrategyActionSpace as ESAS;

use Bga\Games\tycoonindianew\Spec\ActionSpec;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class ExportStrategyMainActionManager extends SAM {

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
      ESAS::instance($args)->insert();
    }
  }

  /**
   * Get sales strategy space definitions
   * @return array
   */
  public function getSpaceDefinitions(): array {
    $action = ESA::instance(\clienttranslate("Discard 4 Promoters to move up 1 step on any Industry sector track, OR discard 7 Promoters to move up 2 steps on any 1 industry sector track OR 1 step on any 2 industry sector tracks."));

    return [
      ["cost" => SAS::generateCost(7), "reward" => SAS::generateReward(FT::FREE_ACTION, 2, new ActionSpec(SectorProductionAction::instance())), "index" => 1, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(7), "reward" => SAS::generateReward(FT::FREE_ACTION, 2, new ActionSpec(SectorProductionAction::instance())), "index" => 2, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(7), "reward" => SAS::generateReward(FT::FREE_ACTION, 2, new ActionSpec(SectorProductionAction::instance())), "index" => 3, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::FREE_ACTION, 1, new ActionSpec(SectorProductionAction::instance())), "index" => 1, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::FREE_ACTION, 1, new ActionSpec(SectorProductionAction::instance())), "index" => 2, "action" => $action, "occupied" => false],
      ["cost" => SAS::generateCost(4), "reward" => SAS::generateReward(FT::FREE_ACTION, 1, new ActionSpec(SectorProductionAction::instance())), "index" => 3, "action" => $action, "occupied" => false]
    ];
  }
}