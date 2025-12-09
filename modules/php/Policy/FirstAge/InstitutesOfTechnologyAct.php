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
 * Name: Institutes of Technology Act
 * Description:
 *  This was passed in 1961 to establish the Indian Institutes of Technology. The IITs are autonomous public engineering and technology-oriented institutes of higher education in India
 *  that are recognized as centers of excellence for engineering and technology education.
 * Type: Economic Policy
 * Politics Bonus: 2 Influence
 * Passive Benefit: Gain 1 Influence during Strategy action
 * Endgame Favor: 3 Favor
 */
class InstitutesOfTechnologyAct extends EconomicPolicyCard {

  /**
   * Passive benefit given by this economic policy card
   * @return Effect
   */
  public static function passiveBenefit(): Effect {
    // TODO: Update trigger to Strategy action
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::INFLUENCE,
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
  const NAME = "Institutes of Technology Act";
  const DESCRIPTION = "This was passed in 1961 to establish the Indian Institutes of Technology. The IITs are autonomous public engineering and technology-oriented institutes of higher education in India that are recognized as centers of excellence for engineering and technology education.";
}