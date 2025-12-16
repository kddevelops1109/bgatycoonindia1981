<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Token\Global;

use Bga\Games\tycoonindianew\Model\DeckItem\Token\Token;

/**
 * Global tokens (endgame favor, tycoon region and round marker) are global (game-level) and not associated with any single player.
 */
abstract class GlobalToken extends Token {

}