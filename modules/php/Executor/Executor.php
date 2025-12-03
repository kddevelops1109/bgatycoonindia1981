<?php
namespace Bga\Games\tycoonindianew\Executor;

/**
 * Used to execute a game function/operation, such as applying of effects, fulfilling promises, etc
 */
abstract class Executor {

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
   * Execute game function/operation
   * @param int|null $player_id Player for whom this executor must execute, if any
   * @return void
   */
  abstract public function execute(?int $player_id, mixed $payload = null): void;
}