<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;
use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Executor\Executor;

/**
 * Executes given effect for given player, if any
 */
abstract class EffectExecutor extends Executor {

  /**
   * Execute the given effect
   * @param int|null $playerId
   * @param mixed $payload
   * @throws InvalidArgumentException
   * @return void
   */
  final public function execute(?int $playerId, mixed $payload = null): void {
    if (!$payload instanceof Effect) {
      throw new InvalidArgumentException("EffectExecutor needs an Effect as payload.");
    }

    $this->applyEffect($playerId, $payload);
  }

  /**
   * Preview the given effect
   * @param int|null $playerId
   * @param mixed $payload
   * @throws InvalidArgumentException
   * @return int
   */
  final public function preview(?int $playerId, mixed $payload = null): int {
    if (!$payload instanceof Effect) {
      throw new InvalidArgumentException("EffectExecutor needs an Effect as payload.");
    }

    return $this->previewEffect($playerId, $payload);
  }

  /**
   * Apply the effect to be executed
   * @param int|null $playerId
   * @param Effect $effect
   * @return void
   */
  abstract public function applyEffect(?int $playerId, Effect $effect): void;

  /**
   * Preview the effect to be executed. Do not apply it, just return the expected value of execution
   * @param int|null $playerId
   * @param Effect $effect
   * @return int
   */
  public function previewEffect(?int $playerId, Effect $effect): int {
    return $effect->amount * $effect->multiplier->value($playerId);
  }
}