<?php
namespace Bga\Games\tycoonindianew\Policy\SecondAge;

use Bga\Games\tycoonindianew\Action\Free\SellCheapestShareAction;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;
use Bga\Games\tycoonindianew\Model\Card\Policy\LiberalPolicyCard;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Spec\ActionSpec;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Name: National Stock Exchange
 * Description:
 *  NSE is one of the two major stock exchanges in India, the other being the Bombay Stock Exchange (BSE). Established in 1992 as India\'s first electronic exchange,
 *  with the aim of providing a modern, transparent and efficient platform for trading in stocks and other securities.
 * Type: Liberal
 * Politics Bonus: 1 Influence
 * Immediate Benefit: 1 Influence per Power and Fuel sector production
 * Endgame Favor: 2
 */
class NationalStockExchange extends LiberalPolicyCard {

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
      "fungibleType" => FT::FREE_ACTION,
      "amount" => 1,
      "condition" => null,
      "spec" => new ActionSpec(SellCheapestShareAction::instance()),
      "multiplier" => StaticMultiplier::instance(1),
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Constants - Misc
   */

  const NAME = "National Stock Exchange";
  const DESCRIPTION = "NSE is one of the two major stock exchanges in India, the other being the Bombay Stock Exchange (BSE). Established in 1992 as India\'s first electronic exchange, with the aim of providing a modern, transparent and efficient platform for trading in stocks and other securities.";
}