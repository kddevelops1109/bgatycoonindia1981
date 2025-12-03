<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Condition\NullCondition;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Spec\NullSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: Consumer Protection Act
 * Description:
 *  The CPA is an Indian law enacted in 1986 to protect the interests of consumers and to provide a mechanism for the redressal of consumer grievances.
 *  The act also provides for the establishment of consumer courts to resolve disputes between consumers and sellers.
 * Type: Liberal
 * Politics Bonus: 2 Influence
 * Immediate Benefit: 5 Influence
 * Endgame Favor: 2
 */
class ConsumerProtectionAct extends LiberalPolicyCard {

  /**
   * Returns the politics bonus given by this liberal policy card
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
   * Returns the immediate benefit given by this liberal policy card
   * @return Effect
   */
  public static function immediateBenefit(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::INFLUENCE,
      "amount" => 5,
      "condition" => NullCondition::get(),
      "spec" => NullSpec::get(),
      "multiplier" => 1,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(RegistryKeyPrefix::GAIN_EFFECT . "_5_" . strtolower(FT::INFLUENCE->value), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "Consumer Protection Act";
  const DESCRIPTION = "The CPA is an Indian law enacted in 1986 to protect the interests of consumers and to provide a mechanism for the redressal of consumer grievances. The act also provides for the establishment of consumer courts to resolve disputes between consumers and sellers.";
}