<?php
namespace Bga\Games\tycoonindianew\Multiplier;

/**
 * Provides a static value as the multiplier
 * @property float $value
 */
class StaticMultiplier implements Multiplier {

  /**
   * Instance per multiplier value
   * @var array<float, StaticMultiplier>
   */
  private static array $instances = [];

  /**
   * Value of the multiplier
   * @var int
   */
  private float $value;

  private function __construct(float $value) {
    $this->value = $value;
  }

  public static function instance(float $value): StaticMultiplier {
    // Ensure multiplier value can only have 1 decimal place max
    $key = number_format($value, 1, ".", ",");

    if (!array_key_exists($key, self::$instances)) {
      self::$instances[$key] = new StaticMultiplier($value);
    }

    return self::$instances[$key];
  }

  public function value(int $playerId): float {
    return $this->value;
  }
}