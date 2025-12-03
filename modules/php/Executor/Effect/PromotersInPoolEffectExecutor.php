<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\Gain;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Type\ConditionStatus;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use BgaUserException;

class PromotersInPoolEffectExecutor extends EffectExecutor {

  public function applyEffect(?int $player_id, Effect $effect): void {
    if ($effect->fungibleType != FT::PROMOTERS_IN_POOL) {
      throw new InvalidArgumentException("Effect needs to be Promoters in Pool one for PromotersInPoolEffectExecutor");
    }

    if (is_null($player_id)) {
      throw new InvalidArgumentException("Player id must not be null for executing Promoters in Pool Effect");
    }

    if ($effect->condition->evaluate() == ConditionStatus::PASS) {
      $delta = $effect->multiplier * $effect->amount;
      if ($effect instanceof Gain) {
        IndustrialistManager::incPlayerCounter($player_id, IndustrialistManager::COUNTER_INDUSTRIALIST_PROMOTERS_IN_POOL, $delta);
      }
      else {
        IndustrialistManager::decPlayerCounter($player_id, IndustrialistManager::COUNTER_INDUSTRIALIST_PROMOTERS_IN_POOL, $delta);
      }
    }
  }
}