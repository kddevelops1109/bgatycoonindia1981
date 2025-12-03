<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Executor\Executor;

/**
 * Executes given effect for given player, if any
 */
abstract class EffectExecutor extends Executor {

  final public function execute(?int $player_id, mixed $payload = null): void {
    if (!$payload instanceof Effect) {
      throw new InvalidArgumentException("EffectExecutor needs an Effect as payload.");
    }

    $this->applyEffect($player_id, $payload);
  }

  /**
   * Apply the effect to be executed
   * @param int|null $player_id
   * @param Effect $effect
   * @return void
   */
  abstract public function applyEffect(?int $player_id, Effect $effect): void;
}