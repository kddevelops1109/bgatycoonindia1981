<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main;

abstract class StrategyMainActionManager extends MainActionManager {

  /**
   * Setup of strategy main action space
   * @param array $players
   * @return void
   */
  public function setupMainActionSpace(): void {
    // TODO: Implement
  }

  /**
   * New game setup for the Strategy main action
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupStrategyActionSpaces();
    parent::setupNewGame($players);
  }
 
  /**
   * Setup all strategy action spaces for specific strategy action
   * @return void
   */
  abstract protected function setupStrategyActionSpaces(): void;

  /**
   * Obtain space definitions for this specific strategy action. Needed in order to create the specific strategy action spaces
   * @return void
   */
  abstract protected function getSpaceDefinitions(): array;
}