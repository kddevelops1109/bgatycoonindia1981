<?php
namespace Bga\Games\tycoonindianew\Action\Free;

use Bga\Games\tycoonindianew\Type\ActionType as AT;

class EmergencyLoanAction extends FreeAction {

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::EMERGENCY_LOAN;
  }
}