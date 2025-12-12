<?php
namespace Bga\Games\tycoonindianew\Type;

enum CardTypeArg: int {
  case AGE_I_INDUSTRY = 1;
  case AGE_II_INDUSTRY = 2;
  case AGE_I_POLICY = 3;
  case AGE_II_POLICY = 4;
  case MERIT = 5;
  case PLANNING_COMMISSION_A = 6;
  case PLANNING_COMMISSION_B = 7;
  case CORPORATE_AGENDA = 8;
  case AGE_I_HEADLINE = 9;
  case AGE_II_HEADLINE = 10;
  case PROMISSARY_NOTE = 11;

  /**
   * Returns the total number of cards available for given card type
   * @return int
   */
  public function numCards(): int {
    return match($this) {
      self::AGE_I_INDUSTRY => 23,
      self::AGE_II_INDUSTRY => 25,
      self::AGE_I_POLICY => 10,
      self::AGE_II_POLICY => 12,
      self::MERIT => 30,
      self::PLANNING_COMMISSION_A => 5,
      self::PLANNING_COMMISSION_B => 7,
      self::CORPORATE_AGENDA => 8,
      self::AGE_I_HEADLINE => 7,
      self::AGE_II_HEADLINE => 5,
      self::PROMISSARY_NOTE => 25
    };
  }
}