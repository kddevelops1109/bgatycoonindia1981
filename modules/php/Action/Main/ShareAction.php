<?php
namespace Bga\Games\tycoonindianew\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionType as AT;

class ShareAction extends MainAction {

  /**
   * Type of action
   * @return AT
   */
  public function actionType(): AT {
    return AT::SHARE;
  }
}