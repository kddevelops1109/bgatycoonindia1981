<?php
namespace Bga\Games\tycoonindianew\Action;

use Bga\Games\tycoonindianew\Contracts\Fungible;
use Bga\Games\tycoonindianew\Type\ActionCategory as AC;
use Bga\Games\tycoonindianew\Type\ActionExecution as AE;
use Bga\Games\tycoonindianew\Type\ActionType as AT;

/**
 * Represents any game action. This includes,
 * - Main actions taken during the Take Actions phase
 * - Free actions taken anytime during the game
 * - Merit actions taken anytime during the game
 * Gane actions are fungibles as they can be gained
 * @property string $description Description of the action
 */
abstract class Action implements Fungible {

  /**
   * Static array of instances
   * @var array<string, static>
   */
  private static array $instances = [];

  private function __construct() {
    $this->description = static::DESCRIPTION;
  }

  final public static function instance(): static {
    $class = static::class;

    if (!isset(self::$instances[$class])) {
        self::$instances[$class] = new static();
    }

    return self::$instances[$class];
  }

  /**
   * Actions can be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return true;
  }

  /**
   * Actions cannot be lost
   * @return bool
   */
  public function canBeLost(): bool {
    return false;
  }

  /**
   * Returns the execution of this action
   * @return AE
   */
  abstract public function actionExecution(): AE;

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