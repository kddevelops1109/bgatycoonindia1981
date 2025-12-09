<?php
namespace Bga\Games\tycoonindianew\Action\Free;

use Bga\Games\tycoonindianew\Type\ActionExecution as AE;
use Bga\Games\tycoonindianew\Type\ActionType as AT;

/**
 * Action to sell player's cheapest available share to the government
 */
class SellCheapestShareAction extends FreeAction {

  /**
   * Action to sell player's cheapest available share to the government is automatic, as no player involvmenet is needed for its execution after initiation
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
    return AT::SELL_CHEAPEST_SHARE;
  }

  /** Constants - Misc */
  const DESCRIPTION = "Sell your cheapest available share to the Government at current price";
}