<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Token;

use Bga\Games\tycoonindianew\Model\DeckItem\DeckItem;

/**
 * Represents a token in tycoon, such as conglomerate bonus, endgame favor, action, plant, +1 action, tycoon action, influence token, sector production tokens, tycoon region and round marker.
 * There are 2 types of tokens:
 * - Player tokens (player actions, +1 actions, tycoon actions, plants, influence tokens, sector production tokens and conglomerate bonuses). These are all tokens that can be associated with a player at any point in the game.
 * - Global tokens (endgame favor, tycoon region and round marker). These are global and not associated with any single player.
 */
abstract class Token extends DeckItem {

  /** Constants - Misc */
  const TABLE_NAME = "tycoon_token";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Model\DeckItem\Token\\";
}