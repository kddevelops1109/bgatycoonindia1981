<?php
namespace Bga\Games\tycoonindianew\Type;

enum TokenTypeArg: int {
  case CONGLOMERATE_BONUS = 1;
  case ENDGAME_SECTOR_FAVOR = 2;
  case ACTION_TOKEN = 3;
  case TYCOON_ACTION = 4;
  case PLUS_ONE_ACTION = 5;
  case PROMOTER_1 = 6;
  case PROMOTER_3 = 7;
  case FAVOR_1 = 8;
  case FAVOR_3 = 9;
  case PLAYER_DISC = 10;
  case PLANT = 11;
  case SHARE = 12;
}