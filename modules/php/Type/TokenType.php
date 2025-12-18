<?php
namespace Bga\Games\tycoonindianew\Type;

enum TokenType: string {
  /** Player tokens (Token available in sets per player) */
  case ACTION = "Action";
  case PLAYER_DISC = "Player Disc";
  case PLANT = "Plant";
  case SHARE = "Share";

  /** Global tokens (Tokens that are available globally) */
  case CONGLOMERATE_BONUS = "Cong Bonus";
  case ENDGAME_SECTOR_FAVOR = "EG Sector Favor";
  case PROMOTER = "Promoter";
  case FAVOR = "Favor";
  case PLUS_ONE_ACTION = "+1 Action";
  case TYCOON = "Tycoon";
  case TYCOON_REGION = "Tycoon Region";
  case ROUND = "Round";
}