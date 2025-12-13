<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Action\Free\SectorProductionAction;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\ActionSpec;
use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: Foreign Investment Promotion Board
 * Description:
 *  The FIPB was an inter-ministerial body in India that was responsible for approving and facilitating foreign direct investment (FDI) in the country.
 *  It was established in 1991 as a part of India\'s liberalization policy to promote foreign investment in the country.
 * Type: Liberal
 * Politics Bonus: 5 crores
 * Immediate Benefit: 1 sector production of choice
 * Endgame Favor: 2
 */
class ForeignInvestmentPromotionBoard extends LiberalPolicyCard {

  /**
   * Returns the politics bonus given by this liberal policy card
   * @return Effect
   */
  public static function politicsBonus(): Effect {
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
   * Returns the immediate benefit given by this liberal policy card
   * @return Effect|null
   */
  public static function immediateBenefit(): ?Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FREE_ACTION,
      "amount" => 20,
      "condition" => null,
      "spec" => new ActionSpec(SectorProductionAction::instance()),
      "multiplier" => StaticMultiplier::instance(1),
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "Foreign Investment Promotion Board";
  const NBR = 1;
  const DESCRIPTION = "The FIPB was an inter-ministerial body in India that was responsible for approving and facilitating foreign direct investment (FDI) in the country. It was established in 1991 as a part of India\'s liberalization policy to promote foreign investment in the country.";
}