<?php
namespace Bga\Games\tycoonindianew\Managers;

use Bga\Games\tycoonindianew\Models\Cards\Card;

class PromissaryNoteCardsManager extends CardsManager {
  
  public function loadCardInstance(string $cardName, array $arr): Card {
    throw new \Exception('Not implemented');
  }

  public function setupNewGame(array $players) {
  
  }

  public function setupNewDeck() {
    
  }
}