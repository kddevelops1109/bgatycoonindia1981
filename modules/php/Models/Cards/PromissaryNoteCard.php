<?php
namespace Bga\Games\tycoonindianew\Models\Cards;

class PromissaryNoteCard extends Card {

  /**
   * Promissary notes do not give any endgame favor
   * @return int
   */
  public function endgameFavor(): int {
    return 0;
  }

  /**
   * Promissary notes give -7 endgame influence
   * @return int
   */
  public function endgameInfluence(): int {
    return -7;
  }

  /**
   * Promissary notes give -50 endgame asset value 
   * @return int
   */
  public function endgameAssetValue(): int {
    return -50;
  }

  /**
   * Constants - Misc
   */
  const NUM_CARDS = 25;
  const CARD_TYPE = "Promissary Note";
  const CARD_TYPE_ARG = 11;
}