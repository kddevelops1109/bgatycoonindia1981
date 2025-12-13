<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\Card\Policy\EconomicPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\CardSpec;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardTypeArg;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

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
      "condition" => null,
      "spec" => new CardSpec(CardTypeArg::MERIT, CardLocation::MERIT_DISPLAY, CardLocation::HAND, null),
      "multiplier" => StaticMultiplier::instance(1),
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */
  const NAME = "Agricultural Prices Commission";
  const NBR = 1;
  const DESCRIPTION = "A statutory body established by the Government of India in 1965 to provide recommendations on agricultural prices and related policies, taking into account production costs, market demand, and supply.";
}