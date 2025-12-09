<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Action\Action;
use Bga\Games\tycoonindianew\Type\ActionCategory as AC;
use Bga\Games\tycoonindianew\Type\ActionExecution as AE;

abstract class MainAction extends Action {

  /**
   * All main actions are manual
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
    return AC::MAIN;
  }
}