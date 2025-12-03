<?php
namespace Bga\Games\tycoonindianew\Action\Free;

use Bga\Games\tycoonindianew\Action\Action;
use Bga\Games\tycoonindianew\Type\ActionCategory as AC;

abstract class FreeAction extends Action {

  /**
   * Returns the category of this action
   * @return AC
   */
  public function category(): AC {
    return AC::FREE;
  }
}