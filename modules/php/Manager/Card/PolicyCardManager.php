<?php
namespace Bga\Games\tycoonindianew\Manager\Card;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\PolicyCard;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;

class PolicyCardManager extends CardManager {
  
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
    // Setup Age I Policies
    $this->setupDeck(CardType::POLICY, CardTypeArg::AGE_I_POLICY, CardLocation::POLICY_DECK_AGE_I, PolicyCard::FILEPATH_AGE_I, PolicyCard::CLASSPATH_AGE_I);
    
    // Setup Age II Policies
    $this->setupDeck(CardType::POLICY, CardTypeArg::AGE_II_POLICY, CardLocation::POLICY_DECK_AGE_II, PolicyCard::FILEPATH_AGE_II, PolicyCard::CLASSPATH_AGE_II);
  }
}