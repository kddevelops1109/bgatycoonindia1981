<?php
namespace Bga\Games\tycoonindianew\Manager\DeckItem\Token\Global;

use Bga\Games\tycoonindianew\Manager\DeckItem\Token\TokenManager;

use Bga\Games\tycoonindianew\Model\DeckItem\Token\Global\ConglomerateBonusToken;

use Bga\Games\tycoonindianew\Type\TokenLocation;
use Bga\Games\tycoonindianew\Type\TokenType;
use Bga\Games\tycoonindianew\Type\TokenTypeArg;

class ConglomerateBonusTokenManager extends TokenManager {

  /**
   * Handle setting up conglomerate bonus tokens as part of new game setup, for given players
   * This MUST only be called once during a game, i.e. during new game setup
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupNewDeck();
  }

  /**
   * Setup new deck of conglomerate bonus tokens
   * This MUST only be called once during a game, i.e. during new game setup
   * @return void
   */
  protected function setupNewDeck() {
    // Setup conglomerate bonus tokens
    $this->setupDeck(TokenType::CONGLOMERATE_BONUS, TokenTypeArg::CONGLOMERATE_BONUS, TokenLocation::CONGLOMERATE_BONUS_DECK, ConglomerateBonusToken::FILEPATH, ConglomerateBonusToken::CLASSPATH);
  }
}