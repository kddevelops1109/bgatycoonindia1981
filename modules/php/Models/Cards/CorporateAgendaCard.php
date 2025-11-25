<?php
namespace Bga\Games\tycoonindianew\Models\Cards;

abstract class CorporateAgendaCard extends Card {

  /**
   * Returns 0 as corporate agenda cards do not give any end game asset value
   * @return int End game asset value
   */
  public function endgameAssetValue(): int {
    return 0;
  }

  /**
   * Returns 0 as corporate agenda cards do not give any end game influence
   * @return int End game influence
   */
  public function endgameInfluence(): int {
    return 0;
  }

  /**
   * Constants - Misc
   */
  const NUM_CARDS = 8;
  const CARD_TYPE = "Corporate Agenda";
  const CARD_TYPE_ARG = 8;
}