<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Policy\EconomicPolicyCard;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Name: Monopolies and Restrictive Trade Practices Act
 * Description:
 *  Under the MRTP Act of 1969, the Government had the power to investigate and regulate companies that were suspected of engaging in anti-competitive practices
 *  such as price-fixing, market sharing, and restricting entry of new competitors.
 * Type: Economic Policy
 * Politics Bonus: 2 Influence
 * Passive Benefit: Gain 1 Influence during Share action
 * Endgame Favor: 3 Favor
 */
class MonopoliesAndRestrictiveTradePracticesAct extends EconomicPolicyCard {

  /**
   * Passive benefit given by this economic policy card
   * @return Effect
   */
  public static function passiveBenefit(): Effect {
    // TODO: Update trigger to Share action
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::INFLUENCE,
      "amount" => 1,
      "condition" => NullCondition::get(),
      "spec" => NullSpec::get(),
      "multiplier" => 1,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(RegistryKeyPrefix::GAIN_EFFECT . "_1_" . strtolower(StringUtil::strSnakeCase(FT::INFLUENCE->value)), $args);
  }

  /**
   * Constants - Misc
   */
  const NAME = "Monopolies and Restrictive Trade Practices Act";
  const DESCRIPTION = "Under the MRTP Act of 1969, the Government had the power to investigate and regulate companies that were suspected of engaging in anti-competitive practices such as price-fixing, market sharing, and restricting entry of new competitors.";
}