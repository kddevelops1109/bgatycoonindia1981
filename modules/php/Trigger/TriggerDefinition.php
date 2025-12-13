<?php
namespace Bga\Games\tycoonindianew\Trigger;

use Bga\Games\tycoonindianew\Contracts\Operation;
use Bga\Games\tycoonindianew\Contracts\Triggerable;

use Bga\Games\tycoonindianew\Type\TriggerTiming;

/**
 * Definition of a trigger associated with a triggerable targe such as an effect, triggered by an operation
 */
class TriggerDefinition {

  /**
   * Triggerable target for this definition
   * @var Triggerable
   */
  public Triggerable $target;


  /**
   * Array of instances by their key
   * @var array<string, TriggerDefinition>
   */
  private static array $instances = [];

  /**
   * Instantiates trigger definition
   * @param string $key Unique key for this trigger definition
   * @param TriggerTiming $timing Timing of the trigger, i.e. pre-operation or post-operation?
   * @param Operation $operation The operation that can cause a trigger from this trigger definition
   */
  private function __construct(
    public readonly string $key,
    public readonly TriggerTiming $timing,
    public readonly Operation $operation
  ) {}

  public static function instance(string $key, TriggerTiming $timing, Operation $operation): TriggerDefinition {
    if (!array_key_exists($key, self::$instances)) {
      self::$instances[$key] = new TriggerDefinition($key, $timing, $operation);
    }

    return self::$instances[$key];
  }

  /**
   * Gets the trigger definition instance for given key
   * @param string $key
   * @return TriggerDefinition|null
   */
  public static function get(string $key): ?TriggerDefinition {
    if (array_key_exists($key, self::$instances)) {
      return self::$instances[$key];
    }

    return null;
  }
}