<?php
namespace Bga\Games\tycoonindianew\Strategy\Scoring\Endgame;

use Bga\Games\tycoonindianew\Contracts\ScoringStrategy;

abstract class EndgameScoringStrategy implements ScoringStrategy {

  /**
   * Array of params to use for the endgame scoring strategy
   * @var array
   */
  protected array $params;

  /**
   * Array of endgame scoring strategy instances by class
   * @var array<class-string, static>
   */
  private static array $instances = [];

  /**
   * Private constructor
   * @param array $params
   */
  protected function __construct(array $params) {
    $this->params = $params;
  }

  public static function instance(array $params): static {
    $class = static::class;

    if (!array_key_exists($class, self::$instances)) {
      self::$instances[$class] = new static($params);
    }

    return self::$instances[$class];
  }
}