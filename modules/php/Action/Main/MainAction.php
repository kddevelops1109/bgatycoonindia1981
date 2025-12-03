<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Action\Action;
use Bga\Games\tycoonindianew\Type\ActionCategory as AC;

abstract class MainAction extends Action {

  /**
   * Returns the category of this action
   * @return AC
   */
  public function category(): AC {
    return AC::MAIN;
  }
}