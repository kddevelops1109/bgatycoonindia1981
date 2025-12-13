<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: Debt Recovery Tribunals
 * Description:
 *  Debt Recovery Tribunals (DRTs) are specialized courts established under the Recovery of Debts Due to Banks and Financial Institutions Act (RDDBFI) of 1993
 *  to facilitate the recovery of unpaid debts by banks and financial institutions from their borrowers.
 * Type: Liberal
 * Politics Bonus: 10 crores
 * Immediate Benefit: 20 crores
 * Endgame Favor: 2
 */
class DebtRecoveryTribunals extends LiberalPolicyCard {

  /**
   * Returns the politics bonus given by this liberal policy card
   * @return Effect
   */
  public static function politicsBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::MONEY,
      "amount" => 10,
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
   * Returns the immediate benefit given by this liberal policy card
   * @return Effect|null
   */
  public static function immediateBenefit(): ?Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::MONEY,
      "amount" => 20,
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

  const NAME = "Debt Recovery Tribunals";
  const NBR = 1;
  const DESCRIPTION = "Debt Recovery Tribunals (DRTs) are specialized courts established under the Recovery of Debts Due to Banks and Financial Institutions Act (RDDBFI) of 1993 to facilitate the recovery of unpaid debts by banks and financial institutions from their borrowers.";
}