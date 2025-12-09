<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Type\ConditionStatus;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class ActionEffectExecutor extends EffectExecutor {

  /**
   * Give the player the number of action tokens corresponding to the effect
   * @param mixed $playerId
   * @param Effect $effect
   * @throws InvalidArgumentException
   * @return void
   */
  public function applyEffect(?int $playerId, Effect $effect): void {
    if ($effect->fungibleType != FT::ACTION_TOKEN) {
      throw new InvalidArgumentException("Effect needs to be Action one for ActionEffectExecutor");
    }

    if (is_null($playerId)) {
      throw new InvalidArgumentException("Player id must not be null for executing Action Effect");
    }

    if ($effect->condition->evaluate() == ConditionStatus::PASS) {
      // Player gains given action tokan
    }
  }
}