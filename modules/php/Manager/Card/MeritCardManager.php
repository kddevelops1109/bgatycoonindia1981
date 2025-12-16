<?php
namespace Bga\Games\tycoonindianew\Manager\Card;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Merit\MeritCard;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;

class MeritCardManager extends CardManager {
  
  /**
   * Handle setting up merits as part of new game setup, for given players
   * This MUST only be called once during a game, i.e. during new game setup
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupNewDeck();
  }

  /**
   * Setup new deck of merits
   * This MUST only be called once during a game, i.e. during new game setup
   * @return void
   */
  protected function setupNewDeck() {
    // Setup Corporate Agendas
    $this->setupDeck(CardType::MERIT, CardTypeArg::MERIT, CardLocation::MERIT_DECK, MeritCard::FILEPATH, MeritCard::CLASSPATH);
  }
}