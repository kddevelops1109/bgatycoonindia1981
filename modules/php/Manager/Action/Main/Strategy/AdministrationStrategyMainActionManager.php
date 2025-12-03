<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main\Strategy;

use Bga\Games\tycoonindianew\Manager\Action\Main\StrategyMainActionManager;

class AdministrationStrategyMainActionManager extends StrategyMainActionManager {

  /**
   * Setup administration strategy action spaces, do nothing
   * @return void
   */
  public function setupStrategyActionSpaces(): void {}

  /**
   * Get administration strategy space definitions (none, as it is always available, and does not a share token)
   * @return array
   */
  public function getSpaceDefinitions(): array {
    return [];
  }
}