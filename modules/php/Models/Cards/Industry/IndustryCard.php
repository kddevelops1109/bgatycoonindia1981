<?php
namespace Bga\Games\tycoonindianew\Models\Cards\Industry;

use Bga\Games\tycoonindianew\Models\Cards\Card;

abstract class IndustryCard extends Card {

  /**
   * Industry cards do not give an endgame favor
   * @return int
   */
  public function endgameFavor(): int {
    return 0;
  }

  /**
   * Industry cards do not give an endgame influence by themselves (only via policy cards)
   * @return int
   */
  public function endgameInfluence(): int {
    return 0;
  }

  /**
   * Constants - Misc
   */
  const CARD_TYPE = "Industry";
}