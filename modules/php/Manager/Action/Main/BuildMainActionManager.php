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
      ActionSpace::FIELD_ACTION => BuildAction::instance()
    ];

    BMAS::instance($args)->insert();
  }
}