<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;
use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Multiplier\DynamicMultiplier;
use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: National Highways Authority of India
 * Description:
 *  NHAI Act was enacted in 1988 to establish the NHAI. It is empowered to plan, develop, and maintain national highways in India, as well as to take up contracts for building and improving such highways.
 *  The NHAI is also responsible for the toll collection on national highways.
 * Type: Liberal
 * Politics Bonus: 5 crores
 * Immediate Benefit: 1 Influence per Agro and Transport sector production
 * Endgame Favor: 2
 */
class NationalHighwaysAuthorityOfIndia extends LiberalPolicyCard {

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
      "multiplier" => new DynamicMultiplier([IndustrialistManager::class, "sumAgroAndTransportSectorProduction"]),
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "National Highways Authority of India";
  const NBR = 1;
  const DESCRIPTION = "NHAI Act was enacted in 1988 to establish the NHAI. It is empowered to plan, develop, and maintain national highways in India, as well as to take up contracts for building and improving such highways. The NHAI is also responsible for the toll collection on national highways.";
}