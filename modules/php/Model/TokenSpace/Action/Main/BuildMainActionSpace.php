<?php
namespace Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main;

use Bga\Games\tycoonindianew\Type\ActionType as AT;

class BuildMainActionSpace extends MainActionSpace {
  
  /**
   * Generate space id for given args
   * @param array|null $args
   * @return string
   */
  public static function generateSpaceId(?array $args): string {
    return strtolower(AT::BUILD->value);
  }
}