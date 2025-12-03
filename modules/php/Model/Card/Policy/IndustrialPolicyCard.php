<?php
namespace Bga\Games\tycoonindianew\Model\Card\Policy;

use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;

/**
 * Industrial policy cards give influence as endgame bonus.
 */
abstract class IndustrialPolicyCard extends PolicyCard {
  
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
      PolicyCard::FIELD_BENEFIT => static::endgameInfluence(),
      PolicyCard::FIELD_POLITICS_BONUS => static::politicsBonus(),
      PolicyCard::FIELD_ENDGAME_FAVOR => static::endgameFavor()
    ];
  }

  /**
   * Multiplier for the endgame influence, such as number of built plants, number of fuel and power industry cards, etc, for the given player (if they own this industrial policy card)
   * @param int $player_id
   * @return int
   */
  abstract protected function applyEndgameInfluenceMultiplier(int $player_id): int;

  /**
   * Apply the endgame influence provided by this industrial policy
   * @return void
   */
  public function applyEndgameInfluence(int $player_id): void {
    $this->benefit->apply($player_id);
  }
}