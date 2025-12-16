<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Action\Main\StrategyAction;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\ActionSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: Telecom Revolution
 * Description:
 *  This revolution refers to the rapid growth and expansion of the telecommunications sector in the country, which began in the late 1990s.
 *  Prior to this period, the telecommunications industry in India was largely controlled by the state-owned Bharat Sanchar Nigam Limited (BSNL).
 * Type: Liberal
 * Politics Bonus: 5 crores
 * Immediate Benefit: 1 Influence per Power and Fuel sector production
 * Endgame Favor: 2
 */
class TelecomRevolution extends LiberalPolicyCard {

  /**
   * Returns the politics bonus given by this liberal policy card
   * @return Effect
   */
  public static function politicsBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::PROMOTERS_IN_HAND,
      "amount" => 1,
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
   * Returns the immediate benefit given by this liberal policy card
   * @return Effect|null
   */
  public static function immediateBenefit(): ?Effect {
    // First, define strategy action effect, then chain it to the 3 promoters in pool effect
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FREE_ACTION,
      "amount" => 1,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => new ActionSpec(StrategyAction::instance()),
      "next" => null,
      "trigger" => null,
      "roundDown" => false
    ];

    $effect = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);

    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::PROMOTERS_IN_POOL,
      "amount" => 3,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "next" => $effect,
      "trigger" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "Telecom Revolution";
  const NBR = 1;
  const DESCRIPTION = "This revolution refers to the rapid growth and expansion of the telecommunications sector in the country, which began in the late 1990s. Prior to this period, the telecommunications industry in India was largely controlled by the state-owned Bharat Sanchar Nigam Limited (BSNL).";
}