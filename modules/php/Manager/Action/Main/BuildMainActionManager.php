<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main;

use Bga\Games\tycoonindianew\Action\Main\BuildAction;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\ActionSpace;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main\BuildMainActionSpace as BMAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\TokenSpace;

class BuildMainActionManager extends MainActionManager {

  /**
   * New game setup of build main action
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players){
    $this->setupMainActionSpace();
  }
  
  /**
   * Setup of build main action space
   * @param array $players
   * @return void
   */
  public function setupMainActionSpace(): void {
    $args = [
      TokenSpace::FIELD_SPACE_ID => BMAS::generateSpaceId(null),
      TokenSpace::FIELD_OCCUPIED => false,
      ActionSpace::FIELD_ACTION => BuildAction::instance("Build an Industrial plant on any city on the Map. Pay the building costs to the leaders, and gain 4 bonuses.")
    ];

    BMAS::instance($args)->insert();
  }
}