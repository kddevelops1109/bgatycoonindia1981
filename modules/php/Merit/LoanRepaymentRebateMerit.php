<?php
namespace Bga\Games\tycoonindianew\Merit;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Merit\SingleEffectMeritCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;

class LoanRepaymentRebateMerit extends SingleEffectMeritCard {

  /**
   * Benefit given by this merit card
   * @return Effect
   */
  public static function benefit(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::LOAN_REBATE,
      "amount" => 20,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec"=> null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /** Constants - Misc */
  const NAME = "Loan Repayment Discount";
  const NBR = 4;
}