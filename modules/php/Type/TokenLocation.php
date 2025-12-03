<?php
namespace Bga\Games\tycoonindianew\Type;

enum TokenLocation: string {
  /** Basic locations */
  case HAND = "hand";
  case DECK = "deck";
  case DISCARDS = "discards";

  /** Tableau locations */
  case CONGLOMERATE_BONUS_TABLEAU = "cong-bonus-tab";

  /** Display locations */
  case CONGLOMERATE_BONUS_DISPLAY = "cong-bonus-disp";
  case ENDGAME_SECTOR_FAVOR_DISPLAY = "egsf-disp";
}