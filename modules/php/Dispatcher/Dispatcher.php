<?php
namespace Bga\Games\tycoonindianew\Dispatcher;

/**
 * Dispatcher is responsible for dispatching a request to execute a game function/operation to the right executor
 */
abstract class Dispatcher {

  /**
   * Static array of instances
   * @var array<string, static>
   */
  private static array $instances = [];

  private function __construct() {}

  final public static function instance(): static {
    $class = static::class;

    if (!isset(self::$instances[$class])) {
        self::$instances[$class] = new static();
    }

    return self::$instances[$class];
  }

  /**
   * Dispatch the relevant executor for given player id, if any, given the relevant payload, if any
   * @param int|null $player_id
   * @param mixed $payload
   * @return void
   */
  abstract public function dispatch(?int $player_id, mixed $payload = null): void;
}