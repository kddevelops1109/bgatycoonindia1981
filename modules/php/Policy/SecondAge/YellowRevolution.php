<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\CardSpec;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardTypeArg;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: Yellow Revolution
 * Description:
 *  The Yellow Revolution in India refers to the significant increase in oilseed production that occurred in the country in 1980-1990s.
 *  It was a response to India\'s growing dependence on imports for edible oils, which was seen as a major threat to the country\'s food security.
 * Type: Liberal
 * Politics Bonus: 1 Influence
 * Immediate Benefit: 2 Merit Cards
 * Endgame Favor: 2
 */
class YellowRevolution extends LiberalPolicyCard {

  /**
   * Returns the politics bonus given by this liberal policy card
   * @return Effect
   */
  public static function politicsBonus(): Effect {
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
   * Returns the immediate benefit given by this liberal policy card
   * @return Effect|null
   */
  public static function immediateBenefit(): ?Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FT::MERIT,
      "amount" => 2,
      "condition" => null,
      "spec" => new CardSpec(CardTypeArg::MERIT, CardLocation::MERIT_DECK, CardLocation::HAND, []),
      "multiplier" => StaticMultiplier::instance(1),
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "Yellow Revolution";
  const NBR = 1;
  const DESCRIPTION = "The Yellow Revolution in India refers to the significant increase in oilseed production that occurred in the country in 1980-1990s. It was a response to India\'s growing dependence on imports for edible oils, which was seen as a major threat to the country\'s food security.";
}