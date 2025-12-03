<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Policy\EconomicPolicyCard;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Spec\CardSpec;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardTypeArg;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Name: Agricultural Prices Commission
 * Description:
 *  A statutory body established by the Government of India in 1965 to provide recommendations on agricultural prices and related policies, taking into account production costs, market demand, and supply.
 * Type: Economic Policy
 * Politics Bonus: 2 Influence
 * Passive Benefit: 1 Merit Card on losing Industry bidding
 * Endgame Favor: 3 Favor
 */
class AgriculturalPricesCommission extends EconomicPolicyCard {

  /**
   * Passive benefit given by this economic policy card
   * @return Effect
   */
  public static function passiveBenefit(): Effect {
    // TODO: Update trigger to losing Industry Bidding
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::MERIT,
      "amount" => 1,
      "condition" => NullCondition::get(),
      "spec" => new CardSpec(CardTypeArg::MERIT, CardLocation::MERIT_DISPLAY, CardLocation::HAND, null),
      "multiplier" => 1,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(RegistryKeyPrefix::GAIN_EFFECT . "_1_" . strtolower(StringUtil::strSnakeCase(FT::MERIT->value)), $args);
  }

  /**
   * Constants - Misc
   */
  const NAME = "Agricultural Prices Commission";
  const DESCRIPTION = "A statutory body established by the Government of India in 1965 to provide recommendations on agricultural prices and related policies, taking into account production costs, market demand, and supply.";
}