<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Action\Main\StrategyAction;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\EconomicPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Trigger\TriggerDefinition;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\TriggerTiming;

use Bga\Games\tycoonindianew\Util\StringUtil;

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
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::INFLUENCE,
      "amount" => 1,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "next" => null,
      "trigger" => TriggerDefinition::instance(StringUtil::classToKebab(self::class), TriggerTiming::POST, StrategyAction::instance()),
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */
  const NAME = "Institutes of Technology Act";
  const NBR = 1;
  const DESCRIPTION = "This was passed in 1961 to establish the Indian Institutes of Technology. The IITs are autonomous public engineering and technology-oriented institutes of higher education in India that are recognized as centers of excellence for engineering and technology education.";
}