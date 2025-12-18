<?php
namespace Bga\Games\tycoonindianew\Type;

enum TokenLocation: string {
  /** Basic locations */
  case HAND = "hand";
  case DECK = "deck";
  case DISCARDS = "discards";

  /** Deck locations */
  case ENDGAME_SECTOR_FAVOR_DECK = "egsf-deck";
  case CONGLOMERATE_BONUS_DECK = "cong-bonus-deck";
  case ACTIONS_DECK = "actions-deck";
  case PLUS_ONE_ACTIONS_DECK = "plus-one-deck";
  case PLANT_DECK = "plant-deck";
  case SHARES_DECK = "shares-deck";
  case PROMOTER_DECK = "promoter-deck";
  case FAVOR_DECK = "favor-deck";
  case PLAYER_DISC_DECK = "plr-disc-deck";

  /** Tableau locations */
  case ACTIONS_TABLEAU = "actions-tableau";
  case PLUS_ONE_ACTIONS_TABLEAU = "plus-one-tableau";
  case TYCOON_ACTION_TABLEAU = "tycoon-tableau";
  case PLANT_TABLEAU = "plant-tableau";
  case CONGLOMERATE_BONUS_TABLEAU = "cong-bonus-tab";
  case SHARES_TABLEAU = "shares-tableau";
  case OPPONENT_SHARES_TABLEAU = "opp-shares-tab";
  case PROMOTER_TABLEAU = "promoter-tableau";
  case FAVOR_TABLEAU = "favor-tableau";

  /** Display locations */
  case CONGLOMERATE_BONUS_DISPLAY = "cong-bonus-disp";
  case ENDGAME_SECTOR_FAVOR_DISPLAY = "egsf-disp";
  case INFLUENCE_DISPLAY = "influence-disp";
  case FINANCE_SECTOR_DISPLAY = "finance-disp";
  case MINERALS_SECTOR_DISPLAY = "minerals-disp";
  case FUEL_SECTOR_DISPLAY = "fuel-disp";
  case AGRO_SECTOR_DISPLAY = "agro-disp";
  case POWER_SECTOR_DISPLAY = "power-disp";
  case TRANSPORT_SECTOR_DISPLAY = "transport-disp";
}