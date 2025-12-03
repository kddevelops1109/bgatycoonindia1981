<?php
namespace Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main;

use Bga\Games\tycoonindianew\Model\TokenSpace\ActionSpace;

/**
 * Space that holds action tokens representing main actions taken by players
 */
abstract class MainActionSpace extends ActionSpace {

  public static function dbFieldMappings(): array {
    return parent::dbFieldMappings();
  }

  /**
   * Constants - Misc
   */
  const TABLE_NAME = "tycoon_main_action_space";
}