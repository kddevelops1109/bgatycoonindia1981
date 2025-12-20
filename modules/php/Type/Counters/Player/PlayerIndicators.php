<?php
namespace Bga\Games\tycoonindianew\Type\Counters\Player;

/**
 * Core indicators for each player
 */
enum PlayerIndicators: string {
  
  /** Indicator tracking player's influence */
  case PLAYER_INFLUENCE = "influence";
  
  /** Indicator tracking player's influence rank, i.e. in case of two players' influence being the same, the rank is the tie breaker */
  case PLAYER_INFLUENCE_RANK = "influence_rank";
  
  /** Indicator tracking player's industrial asset value */
  case PLAYER_ASSET_VALUE = "asset_value";
  
  /** Indicator tracking player's favor */
  case PLAYER_FAVOR = "favor";
  
  /** Indicator tracking player's money in crores */
  case PLAYER_MONEY = "money";
  
  /** Indicator tracking player's promoters in hand */
  case PLAYER_PROMOTERS_IN_HAND = "promoters_in_hand";
  
  /** Indicator tracking player's promoters in pool */
  case PLAYER_PROMOTERS_IN_POOL = "promoters_in_pool";

  /** Indicator tracking player's promissary notes gained */
  case PLAYER_PROMISSARY_NOTES = "promissary_notes";

  /** Indicator tracking player's current loan intake level */
  case PLAYER_LOAN_INTAKE_LEVEL = "loan_intake_level";
}