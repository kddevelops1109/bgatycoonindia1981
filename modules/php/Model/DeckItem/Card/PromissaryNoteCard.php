<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card;

use Bga\Games\tycoonindianew\Contracts\Occupiable;

class PromissaryNoteCard extends Card {

  /**
   * Promissary notes do not give any endgame favor
   * @return void
   */
  public function applyEndgameFavor(int $player_id): void {
    // Do nothing
  }

  /**
   * Promissary notes give -7 endgame influence
   * @return void
   */
  public function applyEndgameInfluence(int $player_id): void {
    // Do nothing
  }

  /**
   * Promissary notes give -50 endgame asset value 
   * @return void
   */
  public function applyEndgameAssetValue(int $player_id): void {
    // Do nothing
  }

  /**
   * Promissary notes can be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return true;
  }

  /**
   * Promissary notes can be lost
   * @return bool
   */
  public function canBeLost(): bool {
    return true;
  }

  /** Constants - Misc */
  const NBR = 25;
}