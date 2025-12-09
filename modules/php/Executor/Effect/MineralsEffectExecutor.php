<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use BgaUserException;
use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\Gain;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Type\ConditionStatus;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class MineralsEffectExecutor extends EffectExecutor {

  public function applyEffect(?int $playerId, Effect $effect): void {
    if ($effect->fungibleType != FT::MINERALS) {
      throw new InvalidArgumentException("Effect needs to be Minerals one for MineralsEffectExecutor");
    }

    if (is_null($playerId)) {
      throw new InvalidArgumentException("Player id must not be null for executing Minerals Effect");
    }

    if ($effect->condition->evaluate() == ConditionStatus::PASS) {
      $delta = $effect->multiplier * $effect->amount;
      if ($effect instanceof Gain) {
        IndustrialistManager::incPlayerCounter($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_MINERALS, $delta);
      }
      else {
        throw new BgaUserException("Players cannot lose sector production");
      }
    }
  }
}