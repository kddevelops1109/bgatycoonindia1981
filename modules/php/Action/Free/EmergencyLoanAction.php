<?php
namespace Bga\Games\tycoonindianew\Action\Free;

use Bga\Games\tycoonindianew\Type\ActionExecution as AE;
use Bga\Games\tycoonindianew\Type\ActionType as AT;

class EmergencyLoanAction extends FreeAction {

  /**
   * Emergency loan action is automatic, as after initiation no player input is needed for its execution
   * @return AE
   */
  public function actionExecution(): AE {
    return AE::AUTOMATIC;
  }

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::EMERGENCY_LOAN;
  }
  
  /** Constants - Misc */
  const DESCRIPTION = "You can always take a free emergency loan, anytime during the game. The intake is capped at 25 Crores money (irrespective of where you stand on the Finance track). You do not spend any Action token. Finally, you MUST collect 1 Promissory Note. Keep it visible at all times.";
}