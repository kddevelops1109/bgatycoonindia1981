<?php
namespace Bga\Games\tycoonindianew\Type;

enum TokenTypeArg: int {
  case CONGLOMERATE_BONUS = 12;
  case ENDGAME_SECTOR_FAVOR = 13;
  case ACTION_TOKEN = 14;
  case TYCOON_ACTION = 15;
  case PLUS_ONE_ACTION = 16;
  case PROMOTER_1 = 17;
  case PROMOTER_3 = 18;
  case FAVOR_1 = 19;
  case FAVOR_3 = 20;

  /**
   * Returns the total number of tokens available for given token type
   * @return int
   */
  public function numTokens(): int {
    return match($this) {
      self::CONGLOMERATE_BONUS => 6,
      self::ENDGAME_SECTOR_FAVOR => 5,
      self::ACTION_TOKEN => 8,
      self::TYCOON_ACTION => 1,
      self::PLUS_ONE_ACTION => 10,
      self::PROMOTER_1 => 30,
      self::PROMOTER_3 => 15,
      self::FAVOR_1 => 21,
      self::FAVOR_3 => 13
    };
  }
}