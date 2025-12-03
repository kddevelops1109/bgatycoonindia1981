<?php
namespace Bga\Games\tycoonindianew\Model\Card\Policy;

use Bga\Games\tycoonindianew\Condition\NullCondition;
use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;
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
   * Returns the endgame favor given by this economic policy card
   * @return Effect
   */
  public static function endgameFavor(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FAVOR,
      "amount" => 2,
      "condition" => NullCondition::get(),
      "spec" => NullSpec::get(),
      "multiplier" => 1,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(RegistryKeyPrefix::GAIN_EFFECT . "_2_" . strtolower(FT::FAVOR->value), $args);
  }

  /**
   * Return args for static field mappings for this liberal policy card
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      PolicyCard::FIELD_DESCRIPTION => static::DESCRIPTION,
      PolicyCard::FIELD_AGE => static::AGE,
      PolicyCard::FIELD_TYPE => static::TYPE,
      PolicyCard::FIELD_BENEFIT_TYPE => static::BENEFIT_TYPE,
      PolicyCard::FIELD_BENEFIT => static::immediateBenefit(),
      PolicyCard::FIELD_POLITICS_BONUS => static::politicsBonus(),
      PolicyCard::FIELD_ENDGAME_FAVOR => static::endgameFavor()
    ];
  }

  /**
   * Liberal policy cards do not give any endgame influence
   * @return int
   */
  public function applyEndgameInfluence(int $player_id): void {
    // Do nothing
  }

  /**
   * Constants - Misc
   */
  const AGE = CardAge::AGE_II;
  const TYPE = PolicyType::LIBERAL;
  const BENEFIT_TYPE = PolicyBenefitType::IMMEDIATE;
}