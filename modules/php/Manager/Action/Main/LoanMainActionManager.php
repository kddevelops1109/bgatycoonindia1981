<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main;

use Bga\Games\tycoonindianew\Action\Main\LoanAction;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\ActionSpace;
use Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main\LoanMainActionSpace as LMAS;
use Bga\Games\tycoonindianew\Model\TokenSpace\TokenSpace;

class LoanMainActionManager extends MainActionManager {

  /**
   * New game setup of loan main action
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players){
    $this->setupMainActionSpace();
  }
  
  /**
   * Setup of loan main action space
   * @param array $players
   * @return void
   */
  public function setupMainActionSpace(): void {
    $args = [
      TokenSpace::FIELD_SPACE_ID => LMAS::generateSpaceId(null),
      TokenSpace::FIELD_OCCUPIED => false,
      ActionSpace::FIELD_ACTION => LoanAction::instance("Gain money from the supply as per your Loan intake level. Collect a Promissory Note and move up 1 step on the Finance Sector Track")
    ];

    LMAS::instance($args)->insert();
  }
}