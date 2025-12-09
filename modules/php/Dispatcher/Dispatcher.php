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
   * @param int|null $playerId ID of the player for whom the relevant executor needs to be invoked
   * @param mixed $payload Payload consisting the details for execution
   * @param bool $bPreviewOnly Whether to execute only for preview
   * @return int|null
   */
  abstract public function dispatch(?int $playerId, mixed $payload = null, bool $bPreviewOnly = true): ?int;
}