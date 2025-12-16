<?php
namespace Bga\Games\tycoonindianew\Merit;

use Bga\Games\tycoonindianew\Action\Main\BuildAction;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Merit\EitherOrEffectMeritCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Trigger\TriggerDefinition;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;
use Bga\Games\tycoonindianew\Type\TriggerTiming;

use Bga\Games\tycoonindianew\Util\StringUtil;

class IndustryCardRebateMerit extends EitherOrEffectMeritCard {

  /**
   * Benefits given by this merit card
   * @return array<Effect>
   */
  public static function benefits(): array {
    $benefits = [];

    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::INDUSTRY_PURCHASE_DISCOUNT,
      "amount" => 20,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec"=> null,
      "trigger" => TriggerDefinition::instance(StringUtil::classToKebab(BuildAction::class), TriggerTiming::PRE, BuildAction::instance()),
      "next" => null,
      "roundDown" => false
    ];

    $effects[] = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);

    // TODO: Update trigger to post industry bidding operation
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::INDUSTRY_PURCHASE_DISCOUNT,
      "amount" => 15,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec"=> null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    $effects[] = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);

    return $effects;
  }

  /** Constants - Misc */
  const NAME = "Industry Card Rebate";
  const NBR = 4;
}