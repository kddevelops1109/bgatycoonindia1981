<?php
namespace Bga\Games\tycoonindianew\Merit;

use Bga\Games\tycoonindianew\Action\Main\BuildAction;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Merit\SingleEffectMeritCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Trigger\TriggerDefinition;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;
use Bga\Games\tycoonindianew\Type\TriggerTiming;

use Bga\Games\tycoonindianew\Util\StringUtil;

class BuildActionDiscountMerit extends SingleEffectMeritCard {

  /**
   * Benefit given by this merit card
   * @return Effect
   */
  public static function benefit(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::BUILD_ACTION_DISCOUNT,
      "amount" => 1,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec"=> null,
      "trigger" => TriggerDefinition::instance(StringUtil::classToKebab(BuildAction::class), TriggerTiming::PRE, BuildAction::instance()),
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /** Constants - Misc */
  const NAME = "Build Action Discount";
  const NBR = 3;
}