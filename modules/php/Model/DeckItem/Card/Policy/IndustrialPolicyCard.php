<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Multiplier\DynamicMultiplier;
use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\PolicyBenefitType;
use Bga\Games\tycoonindianew\Type\PolicyType;

/**
 * Industrial policy cards give influence as endgame bonus.
 */
abstract class IndustrialPolicyCard extends PolicyCard {

  public function __construct($args) {
    parent::__construct($args);

    $effectArgs = [
      "fieldName" => PolicyCard::FIELD_BENEFIT,
      "type" => EffectType::GAIN,
      "fungibleType" => FT::INFLUENCE,
      "amount" => 1,
      "multiplier" => new DynamicMultiplier([$this, "obtainEndgameInfluenceMultiplier"]),
      "condition" => null,
      "spec" => null,
      "next" => null,
      "trigger" => null,
      "roundDown" => false
    ];

    $this->assignEffect($effectArgs);
  }

  /**
   * Return the politics bonus effect for industrial policy cards
   * @return Effect
   */
  public static function politicsBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::PROMOTERS_IN_HAND,
      "amount" => 2,
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
   * Return the endgame favor effect for economic policy cards
   * @return Effect
   */
  public static function endgameFavor(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FAVOR,
      "amount" => 2,
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
   * Obtain the endgame influence multiplier for given player for the specific policy card calling this function (from its effect's multiplier)
   * @param int $playerId
   * @return float
   */
  abstract public function obtainEndgameInfluenceMultiplier(int $playerId): float;

  const AGE = CardAge::AGE_I;
  const TYPE = PolicyType::INDUSTRIAL;
  const BENEFIT_TYPE = PolicyBenefitType::ENDGAME;
}