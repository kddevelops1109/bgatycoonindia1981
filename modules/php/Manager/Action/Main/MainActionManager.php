<?php
namespace Bga\Games\tycoonindianew\Manager\Action\Main;

use Bga\Games\tycoonindianew\Manager\Action\ActionManager;

abstract class MainActionManager extends ActionManager {

  /**
   * Static array of instances
   * @var array<string, static>
   */
  protected static array $instances = [];

  private function __construct() {}

  final public static function instance(): static {
    $class = static::class;

    if (!isset(self::$instances[$class])) {
        self::$instances[$class] = new static();
    }

    return self::$instances[$class];
  }

  /**
   * New game setup of main action
   * @param array $players
   * @return void
   */
  abstract public function setupNewGame(array $players);

  /**
   * Setup specific main action space
   * @return void
   */
  abstract public function setupMainActionSpace(): void;
}