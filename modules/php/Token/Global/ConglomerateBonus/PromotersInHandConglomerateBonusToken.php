<?php
namespace Bga\Games\tycoonindianew\Token\Global\ConglomerateBonus;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\DeckItem\Token\Global\ConglomerateBonusToken;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;

class PromotersInHandConglomerateBonusToken extends ConglomerateBonusToken {

  public static function conglomerateBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::PROMOTERS_IN_HAND,
      "amount" => 9,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    $firstBonus = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);

    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::INFLUENCE,
      "amount" => 3,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => $firstBonus,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /** Constants - Misc */
  const NAME = "Gain 9 Promoters in Hand + 3 Influence";
  const NBR = 1;
}