<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main;

use Bga\Games\tycoonindianew\Action\Main\StrategyAction;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\ActionSpace;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main\StrategyMainActionSpace as SMAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\TokenSpace;

class StrategyMainActionManager extends MainActionManager {

  /**
   * Setup of strategy main action space
   * @param array $players
   * @return void
   */
  public function setupMainActionSpace(): void {
    $args = [
      TokenSpace::FIELD_SPACE_ID => SMAS::generateSpaceId(null),
      TokenSpace::FIELD_OCCUPIED => false,
      ActionSpace::FIELD_ACTION => StrategyAction::instance("Discard a number of Promoters to gain any 1 bonus printed on one of the available Strategy Actions spaces.")
    ];

    SMAS::instance($args)->insert();
  }

  /**
   * New game setup for the Strategy main action
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupMainActionSpace();
  }
 
  /**
   * Setup all strategy action spaces for specific strategy action
   * @return void
   */
  protected function setupStrategyActionSpaces(): void {
    // Do nothing
  }

  /**
   * Obtain space definitions for this specific strategy action. Needed in order to create the specific strategy action spaces
   * @return array
   */
  protected function getSpaceDefinitions(): array {
    // Do nothing
    return [];
  }
}