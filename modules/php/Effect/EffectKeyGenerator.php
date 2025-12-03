<?php
namespace Bga\Games\tycoonindianew\Effect;

use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

class EffectKeyGenerator {

  /**
   * Generate key for given effect type, fungible type, amount and multiplier
   * @param EffectType $effectType
   * @param FT $fungibleType
   * @param int $amount
   * @param int $multiplier
   * @return string
   */
  public static function generate(EffectType $effectType, FT $fungibleType, int $amount, int $multiplier) {
    if ($effectType == EffectType::GAIN) {
      return implode("_", [RegistryKeyPrefix::GAIN_EFFECT, strtolower(str_replace(" ", "_", $fungibleType->value)), $amount, $multiplier]);
    }
    else {
      return implode("_", [RegistryKeyPrefix::LOSE_EFFECT, strtolower(str_replace(" ", "_", $fungibleType->value)), $amount, $multiplier]);
    }
  }
}