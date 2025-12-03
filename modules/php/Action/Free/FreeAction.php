<?php
namespace Bga\Games\tycoonindianew\Action\Free;

use Bga\Games\tycoonindianew\Action\Action;
use Bga\Games\tycoonindianew\Type\ActionCategory;

abstract class FreeAction extends Action {

  /**
   * Returns the category of this action
   * @return ActionCategory
   */
  public function category(): ActionCategory {
    return ActionCategory::FREE;
  }
}