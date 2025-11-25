<?php
namespace Bga\Games\tycoonindianew\Models\Cards\Headline;

use Bga\Games\tycoonindianew\Models\Cards\Card;

abstract class HeadlineCard extends Card {

  /**
   * TODO: Implement
   * @return int
   */
  public function endgameFavor(): int {
    return 0;
  }

  /**
   * TODO: Implement
   * @return int
   */
  public function endgameInfluence(): int {
    return 0;
  }

  /**
   * TODO: Implement
   * @return int
   */
  public function endgameAssetValue(): int {
    return 0;
  }

  /**
   * Constants - Misc
   */
  const CARD_TYPE = "Headline";
}