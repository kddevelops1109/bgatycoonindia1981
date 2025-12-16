<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\PolicyBenefitType;
use Bga\Games\tycoonindianew\Type\PolicyType;

/**
 * Liberal policy cards give immediate benefits. They do not give any endgame influence.
 */
abstract class LiberalPolicyCard extends PolicyCard {

  /**
   * Immediate benefit provided by liberal policy card
   * @return Effect|null
  */
  abstract public static function immediateBenefit(): ?Effect;

  /**
   * Return the endgame favor effect for economic policy cards
   * @return Effect
   */
  public static function endgameFavor(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FAVOR,
      "amount" => 3,
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
   * Static field args for liberal policy cards
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      ... parent::staticFieldArgs(),
      [
        PolicyCard::FIELD_BENEFIT => static::immediateBenefit()
      ]
    ];
  }

  /**
   * Constants - Misc
   */
  const AGE = CardAge::AGE_II;
  const TYPE = PolicyType::LIBERAL;
  const BENEFIT_TYPE = PolicyBenefitType::IMMEDIATE;
}