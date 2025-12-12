<?php
namespace Bga\Games\tycoonindianew\Model\Card\Policy;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\PolicyBenefitType;
use Bga\Games\tycoonindianew\Type\PolicyType;

/**
 * Economic policy cards give passive benefits. They do not give any endgame influence.
 */
abstract class EconomicPolicyCard extends PolicyCard {

  /**
   * Passive benefit given by the economic policy card
   * @return void
   */
  abstract public static function passiveBenefit(): Effect;

  /**
   * Return the politics bonus effect for economic policy cards
   * @return Effect
   */
  public static function politicsBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::INFLUENCE,
      "amount" => 2,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "next" => null,
      "trigger" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Return the endgame favor effect for economic policy cards
   * @return Effect
   */
  public static function endgameFavor(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FAVOR,
      "amount" => 3,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "next" => null,
      "trigger" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Static field args for economic policy cards
   * @return array<Effect[]|mixed>
   */
  public static function staticFieldArgs(): array {
    return [
      ... parent::staticFieldArgs(),
      [
        PolicyCard::FIELD_BENEFIT => static::passiveBenefit()
      ]
    ];
  }

  const AGE = CardAge::AGE_I;
  const TYPE = PolicyType::ECONOMIC;
  const BENEFIT_TYPE = PolicyBenefitType::PASSIVE;
}