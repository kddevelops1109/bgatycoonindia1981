<?php
namespace Bga\Games\tycoonindianew\Executor\Effect;

use Exception;
use InvalidArgumentException;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\Gain;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Type\ConditionStatus;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use BgaUserException;

class FavorEffectExecutor extends EffectExecutor {

  public function applyEffect(?int $playerId, Effect $effect): void {
    if ($effect->fungibleType != FT::FAVOR) {
      throw new InvalidArgumentException("Effect needs to be Favor one for FavorEffectExecutor");
    }

    if (is_null($playerId)) {
      throw new InvalidArgumentException("Player id must not be null for executing Favor Effect");
    }

    if ($effect->condition->evaluate() == ConditionStatus::PASS) {
      $delta = $effect->multiplier * $effect->amount;
      if ($effect instanceof Gain) {
        IndustrialistManager::incPlayerCounter($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_FAVOR, $delta);
      }
      else {
        throw new BgaUserException("Players cannot lose favor");
      }
    }
  }
}