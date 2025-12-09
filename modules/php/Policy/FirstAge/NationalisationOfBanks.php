<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\Card\Policy\EconomicPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: Nationalisation of Banks
 * Description:
 *  A significant economic policy taken by the Government of India in 1969. When it nationalized 14 major commercial banks in the country for the promotion of financial inclusion,
 *  the mobilization of resources for development, and the promotion of economic growth.
 * Type: Economic Policy
 * Politics Bonus: 2 Influence
 * Passive Benefit: Gain 5 crores during Loan action
 * Endgame Favor: 3 Favor
 */
class NationalisationOfBanks extends EconomicPolicyCard {

  /**
   * Passive benefit given by this economic policy card
   * @return Effect
   */
  public static function passiveBenefit(): Effect {
    // TODO: Update trigger to Loan action
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::MONEY,
      "amount" => 5,
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
   * Constants - Misc
   */
  const NAME = "Nationalisation of Banks";
  const DESCRIPTION = "A significant economic policy taken by the Government of India in 1969. When it nationalized 14 major commercial banks in the country for the promotion of financial inclusion, the mobilization of resources for development, and the promotion of economic growth.";
}