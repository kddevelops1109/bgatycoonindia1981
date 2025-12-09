<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionType as AT;

class PoliticsAction extends MainAction {

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::POLITICS;
  }

  /** Constants - Misc */
  const DESCRIPTION = "Gain all the “Politics” bonuses printed on each of your Policies. Then, gain a Favor token.";
}