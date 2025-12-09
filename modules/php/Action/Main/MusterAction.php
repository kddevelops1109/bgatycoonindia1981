<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionType as AT;

class MusterAction extends MainAction {

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::MUSTER;
  }

  /** Constants - Misc */
  const DESCRIPTION = "Add promoters from your hand to your own Strategy Pool, in order to take powerful Strategy actions in later turns. Then, gain a Merit card.";
}