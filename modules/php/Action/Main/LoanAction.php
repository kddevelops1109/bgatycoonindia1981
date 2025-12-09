<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionType as AT;

class LoanAction extends MainAction {

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::LOAN;
  }

  /** Constants - Misc */
  const DESCRIPTION = "Gain money from the supply as per your Loan intake level. Collect a Promissory Note and move up 1 step on the Finance Sector Track";
}