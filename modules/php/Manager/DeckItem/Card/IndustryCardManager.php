<?php
namespace Bga\Games\tycoonindianew\Manager\DeckItem\Card;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Industry\IndustryCard;
use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;

class IndustryCardManager extends CardManager {

  /**
   * Handle setting up policies as part of new game setup, for given players
   * This MUST only be called once during a game, i.e. during new game setup
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players) {
    $this->setupNewDeck();
  }

  /**
   * Setup new deck of policies
   * This MUST only be called once during a game, i.e. during new game setup
   * @return void
   */
  protected function setupNewDeck() {
    // Setup Age I Industries
    $this->setupDeck(CardType::INDUSTRY, CardTypeArg::AGE_I_INDUSTRY, CardLocation::INDUSTRY_DECK_AGE_I, IndustryCard::FILEPATH_AGE_I, IndustryCard::CLASSPATH_AGE_I);
    
    // Setup Age II Industries
    $this->setupDeck(CardType::INDUSTRY, CardTypeArg::AGE_II_INDUSTRY, CardLocation::INDUSTRY_DECK_AGE_II, IndustryCard::FILEPATH_AGE_II, IndustryCard::CLASSPATH_AGE_II);
  }
}