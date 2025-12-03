<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main;

use Bga\Games\tycoonindianew\Action\Main\PoliticsAction;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\ActionSpace;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main\PoliticsMainActionSpace as PMAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\TokenSpace;

class PoliticsMainActionManager extends MainActionManager {

  /**
   * New game setup of politics main action
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players){
    $this->setupMainActionSpace();
  }
  
  /**
   * Setup of politics main action space
   * @param array $players
   * @return void
   */
  public function setupMainActionSpace(): void {
    $args = [
      TokenSpace::FIELD_SPACE_ID => PMAS::generateSpaceId(null),
      TokenSpace::FIELD_OCCUPIED => false,
      ActionSpace::FIELD_ACTION => PoliticsAction::instance("Gain all the “Politics” bonuses printed on each of your Policies. Then, gain a Favor token.")
    ];

    PMAS::instance($args)->insert();
  }
}