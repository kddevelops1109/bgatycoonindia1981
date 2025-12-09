<?php
namespace Bga\Games\tycoonindianew\Effect;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;
use Bga\Games\tycoonindianew\Type\EffectType;
use BgaVisibleSystemException;

class EffectKeyGenerator {

  /**
   * Generate key for given effect type, fungible type, amount and multiplier
   * @param array $args
   * @return string
   */
  public static function generate(array $args): string {
    // throw new BgaVisibleSystemException(print_r($args, true));

    $effectType = $args["type"];
    $fungibleType = $args["fungibleType"];
    $amount = $args["amount"];
    $multiplier = $args["multiplier"];
    if ($multiplier instanceof StaticMultiplier) {
      $multiplier = $multiplier->value(0);
    }
    else {
      $multiplier = "dynamic";
    }

    if ($effectType == EffectType::GAIN) {
      return implode("_", [RegistryKeyPrefix::GAIN_EFFECT->value, $amount, $multiplier,strtolower(str_replace(" ", "_", $fungibleType->value))]);
    }
    else {
      return implode("_", [RegistryKeyPrefix::LOSE_EFFECT->value, $amount, $multiplier, strtolower(str_replace(" ", "_", $fungibleType->value))]);
    }
  }
}