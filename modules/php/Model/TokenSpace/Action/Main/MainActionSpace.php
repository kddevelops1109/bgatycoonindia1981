<?php
namespace Bga\Games\tycoonindianew\Model\TokenSpace\Action\Main;

use Bga\Games\tycoonindianew\Model\TokenSpace\Action\ActionSpace;
use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Space that holds action tokens representing main actions taken by players
 */
abstract class MainActionSpace extends ActionSpace {

  /**
   * Static array of instances
   * @var array
   */
  public static array $instances = [];

  /**
   * Get specific instance
   * @param array $args
   * @return static
   */
  final public static function instance(array $args): static {
    $class = static::class;

    if (!array_key_exists($class, self::$instances)) {
      $instances[$class] = new $class($args);
    }

    return $instances[$class];
  }

  public static function dbFieldMappings(): array {
    return parent::dbFieldMappings();
  }

  /**
   * Constants - Misc
   */
  const TABLE_NAME = "tycoon_main_action_space";
}