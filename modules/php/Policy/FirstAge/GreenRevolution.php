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
 * Name: Green Revolution
 * Description:
 *  Led by Dr M.S. Swaminathan in 1967, this revolution helped significantly increase agricultural production and reduce dependence on food imports, making India self-sufficient in food grains.
 *  This also led to improved incomes and living standards for farmers and rural communities
 * Type: Economic Policy
 * Politics Bonus: 2 Influence
 * Passive Benefit: Gain 1 Promoter in Pool during Muster action
 * Endgame Favor: 3 Favor
 */
class GreenRevolution extends EconomicPolicyCard {

  /**
   * Passive benefit given by this economic policy card
   * @return Effect
   */
  public static function passiveBenefit(): Effect {
    // TODO: Update trigger to Muster action
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::PROMOTERS_IN_POOL,
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
   * Constants - Misc
   */
  const NAME = "Green Revolution";
  const DESCRIPTION = "Led by Dr M.S. Swaminathan in 1967, this revolution helped significantly increase agricultural production and reduce dependence on food imports, making India self-sufficient in food grains. This also led to improved incomes and living standards for farmers and rural communities";
}