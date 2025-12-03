<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main;

use Bga\Games\tycoonindianew\Action\Main\MusterAction;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\ActionSpace;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main\MusterMainActionSpace as MMAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\TokenSpace;

class MusterMainActionManager extends MainActionManager {

  /**
   * New game setup of muster main action
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players){
    $this->setupMainActionSpace();
  }
  
  /**
   * Setup of muster main action space
   * @param array $players
   * @return void
   */
  public function setupMainActionSpace(): void {
    $args = [
      TokenSpace::FIELD_SPACE_ID => MMAS::generateSpaceId(null),
      TokenSpace::FIELD_OCCUPIED => false,
      ActionSpace::FIELD_ACTION => MusterAction::instance("Add promoters from your hand to your own Strategy Pool, in order to take powerful Strategy actions in later turns. Then, gain a Merit card.")
    ];

    MMAS::instance($args)->insert();
  }
}