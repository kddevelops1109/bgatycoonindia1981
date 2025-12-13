<?php
namespace Bga\Games\tycoonindianew\Merit;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\Card\Merit\EitherOrEffectMeritCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;

class AssetValueOrMoneyMerit extends EitherOrEffectMeritCard {

  /**
   * Benefits given by this merit card
   * @return array<Effect>
   */
  public static function benefits(): array {
    $benefits = [];

    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::ASSET_VALUE,
      "amount" => 20,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec"=> null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    $effects[] = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);

    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::MONEY,
      "amount" => 15,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec"=> null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    $effects[] = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);

    return $effects;
  }

  /** Constants - Misc */
  const NAME = "Asset Value or Money";
  const NBR = 6;
}