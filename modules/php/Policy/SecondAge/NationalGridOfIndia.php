<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Action\Free\SectorProductionAction;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Multiplier\DynamicMultiplier;
use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\ActionSpec;
use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: National Grid of India
 * Description:
 *  The National Grid of India is one of the largest transmission networks in the world, with a total transmission capacity of over 3,67,000 circuit kilometers.
 *  It connects all major regional grids in the country, enabling the seamless transfer of electricity across the country.
 * Type: Liberal
 * Politics Bonus: 5 crores
 * Immediate Benefit: 1 Influence per Power and Fuel sector production
 * Endgame Favor: 2
 */
class NationalGridOfIndia extends LiberalPolicyCard {

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
      "multiplier" => new DynamicMultiplier([IndustrialistManager::class, "sumPowerAndFuelSectorProduction"]),
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "National Grid of India";
  const NBR = 1;
  const DESCRIPTION = "The National Grid of India is one of the largest transmission networks in the world, with a total transmission capacity of over 3,67,000 circuit kilometers. It connects all major regional grids in the country, enabling the seamless transfer of electricity across the country.";
}