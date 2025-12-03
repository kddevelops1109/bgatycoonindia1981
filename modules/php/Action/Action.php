<?php
namespace Bga\Games\tycoonindianew\Action;

use Bga\Games\tycoonindianew\Type\ActionCategory as AC;
use Bga\Games\tycoonindianew\Type\ActionType as AT;

/**
 * Represents any game action. This includes,
 * - Main actions taken during the Take Actions phase
 * - Free actions taken anytime during the game
 * - Merit actions taken anytime during the game
 * @property string $description Description of the action
 */
abstract class Action {

  /**
   * Static array of instances
   * @var array<string, static>
   */
  private static array $instances = [];

  private function __construct(
    public readonly string $description
  ) {}

  final public static function instance(string $description): static {
    $class = static::class;

    if (!isset(self::$instances[$class])) {
        self::$instances[$class] = new static($description);
    }

    return self::$instances[$class];
  }

  /**
   * Returns the type of this action
   * @return AT
   */
  abstract public function actionType(): AT;

  /**
   * Returns the category of this action
   * @return AC
   */
  abstract public function category(): AC;
}