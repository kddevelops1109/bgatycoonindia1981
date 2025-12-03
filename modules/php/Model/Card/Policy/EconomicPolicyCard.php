<?php
namespace Bga\Games\tycoonindianew\Model\Card\Policy;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\PolicyBenefitType;
use Bga\Games\tycoonindianew\Type\PolicyType;

/**
 * Economic policy cards give passive benefits. They do not give any endgame influence.
 */
abstract class EconomicPolicyCard extends PolicyCard {

  /**
   * Returns the politics bonus given by this economic policy card
   * @return Effect
   */
  public static function politicsBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::INFLUENCE,
      "amount" => 2,
      "condition" => NullCondition::get(),
      "spec" => NullSpec::get(),
      "multiplier" => 1,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(RegistryKeyPrefix::GAIN_EFFECT . "_2_" . strtolower(FT::INFLUENCE->value), $args);
  }

  /**
   * Returns the endgame favor given by this economic policy card
   * @return Effect
   */
  public static function endgameFavor(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::FAVOR,
      "amount" => 3,
      "condition" => NullCondition::get(),
      "spec" => NullSpec::get(),
      "multiplier" => 1,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(RegistryKeyPrefix::GAIN_EFFECT . "_3_" . strtolower(FT::FAVOR->value), $args);
  }

  /**
   * Return args for static field mappings
   * @return array
   */
  public static function staticFieldArgs(): array {
    return [
      PolicyCard::FIELD_DESCRIPTION => static::DESCRIPTION,
      PolicyCard::FIELD_AGE => static::AGE,
      PolicyCard::FIELD_TYPE => static::TYPE,
      PolicyCard::FIELD_BENEFIT_TYPE => static::BENEFIT_TYPE,
      PolicyCard::FIELD_BENEFIT => static::passiveBenefit(),
      PolicyCard::FIELD_POLITICS_BONUS => static::politicsBonus(),
      PolicyCard::FIELD_ENDGAME_FAVOR => static::endgameFavor()
    ];
  }

  /**
   * Economic policy cards do not give any endgame influence
   * @return void
   */
  public function applyEndgameInfluence(int $player_id): void {
    // Do nothing
  }

  const AGE = CardAge::AGE_I;
  const TYPE = PolicyType::ECONOMIC;
  const BENEFIT_TYPE = PolicyBenefitType::PASSIVE;
}