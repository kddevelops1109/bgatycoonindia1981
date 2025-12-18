<?php
namespace Bga\Games\tycoonindianew\Manager\DeckItem\Token;

use Bga\Games\tycoonindianew\Model\DeckItem\Token\Global\EndgameSectorFavorToken;
use Bga\Games\tycoonindianew\Type\TokenLocation;
use Bga\Games\tycoonindianew\Type\TokenType;
use Bga\Games\tycoonindianew\Type\TokenTypeArg;

class EndgameSectorFavorTokenManager extends TokenManager {

  /**
   * Handle setting up endgame sector favor tokens as part of new game setup, for given players
   * This MUST only be called once during a game, i.e. during new game setup
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupNewDeck();
  }

  /**
   * Setup new deck of endgame sector favor tokens
   * This MUST only be called once during a game, i.e. during new game setup
   * @return void
   */
  protected function setupNewDeck() {
    // Setup endgame sector favor tokens
    $this->setupDeck(TokenType::ENDGAME_SECTOR_FAVOR, TokenTypeArg::ENDGAME_SECTOR_FAVOR, TokenLocation::DECK, EndgameSectorFavorToken::FILEPATH, EndgameSectorFavorToken::CLASSPATH);
  }
}