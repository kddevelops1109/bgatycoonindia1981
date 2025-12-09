<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Type\ConditionStatus;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class TycoonActionEffectExecutor extends EffectExecutor {

  public function applyEffect(?int $playerId, Effect $effect): void {
    if ($effect->fungibleType != FT::TYCOON_ACTION) {
      throw new InvalidArgumentException("Effect needs to be Tycoon Action one for TycoonActionEffectExecutor");
    }

    if (is_null($playerId)) {
      throw new InvalidArgumentException("Player id must not be null for executing Tycoon Action Effect");
    }

    if ($effect->condition->evaluate() == ConditionStatus::PASS) {
      // Player gains given corporate agenda into their hand
    }
  }
}