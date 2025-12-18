<?php
namespace Bga\Games\tycoonindianew\Manager\DeckItem\Card;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\CorporateAgendaCard;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;

class CorporateAgendaCardManager extends CardManager {

  /**
   * Handle setting up corporate agendas as part of new game setup, for given players
   * This MUST only be called once during a game, i.e. during new game setup
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupNewDeck();
  }

  /**
   * Setup new deck of corporate agendas
   * This MUST only be called once during a game, i.e. during new game setup
   * @return void
   */
  protected function setupNewDeck() {
    // Setup Corporate Agendas
    $this->setupDeck(CardType::CORPORATE_AGENDA, CardTypeArg::CORPORATE_AGENDA, CardLocation::CORPORATE_AGENDA_DECK, CorporateAgendaCard::FILEPATH, CorporateAgendaCard::CLASSPATH);
  }
}