<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Action\Free\SectorProductionAction;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Multiplier\DynamicMultiplier;
use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\ActionSpec;
use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: The Environment Protection Act
 * Description:
 *  The EPA was passed in 1986 with the objective of protecting and improving the quality of the environment and preventing environmental pollution.
 *  The EPA empowers the the Central Government to establish standards for emissions and discharge of pollutants.
 * Type: Liberal
 * Politics Bonus: 5 crores
 * Immediate Benefit: 1 Influence per industry and policy card, including this
 * Endgame Favor: 2
 */
class TheEnvironmentProtectionAct extends LiberalPolicyCard {

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
      "fungibleType" => FT::INFLUENCE,
      "amount" => 1,
      "condition" => null,
      "spec" => null,
      "multiplier" => new DynamicMultiplier([IndustrialistManager::class, "countPolicyIndustryCards"]),
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "The Environment Protection Act";
  const NBR = 1;
  const DESCRIPTION = "The EPA was passed in 1986 with the objective of protecting and improving the quality of the environment and preventing environmental pollution. The EPA empowers the the Central Government to establish standards for emissions and discharge of pollutants.";
}