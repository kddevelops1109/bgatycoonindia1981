<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Type\ConditionStatus;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class PolicyEffectExecutor extends EffectExecutor {

  public function applyEffect(?int $player_id, Effect $effect): void {
    if ($effect->fungibleType != FT::POLICY) {
      throw new InvalidArgumentException("Effect needs to be Policy one for PolicyEffectExecutor");
    }

    if (is_null($player_id)) {
      throw new InvalidArgumentException("Player id must not be null for executing Policy Effect");
    }

    if ($effect->condition->evaluate() == ConditionStatus::PASS) {
      // Player gains given corporate agenda into their hand
    }
  }
}