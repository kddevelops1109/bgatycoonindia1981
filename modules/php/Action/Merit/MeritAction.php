<?php
namespace Bga\Games\tycoonindianew\Action\Merit;

use Bga\Games\tycoonindianew\Action\Action;
use Bga\Games\tycoonindianew\Type\ActionCategory as AC;
use Bga\Games\tycoonindianew\Type\ActionExecution as AE;

abstract class MeritAction extends Action {

  /**
   * All merit actions are manual
   * @return AE
   */
  public function actionExecution(): AE {
    return AE::MANUAL;
  }

  /**
   * Returns the category of this action
   * @return AC
   */
  public function category(): AC {
    return AC::MERIT;
  }
}