<?php
namespace Bga\Games\tycoonindianew\Managers;

use Bga\Games\tycoonindianew\Game;
use Bga\Games\tycoonindianew\Models\Cards\Card;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;

class CorporateAgendaCardsManager extends CardsManager {

  public function setupNewGame(array $players) {
    $this->setupNewDeck();
  }

  protected function setupNewDeck() {
    $this->deck = Game::get()->deckFactory->createDeck(Card::TABLE_NAME);
    $this->deck->init(Card::TABLE_NAME);

    $cards = [];
    for ($i = 0; $i < CorporateAgendaCard::NUM_CARDS; $i++) {
      $cards[] = [
        'type' => CorporateAgendaCard::CARD_TYPE,
        'type_arg' => CorporateAgendaCard::CARD_TYPE_ARG,
        'nbr' => 1
      ];
    }

    $this->deck->createCards($cards, Card::LOCATION_DECK);

    $this->deck->shuffle(Card::LOCATION_DECK);
  }

  protected function loadCardInstance(string $cardName, array $arr): Card {
    $className = "\Bga\Games\tycoonindianew\CorporateAgendas\\$cardName";
    return new $className($arr);
  }

  protected function loadNewCardInstances() {
    // Load list of cards
    include_once dirname(__FILE__) . '/../CorporateAgendas/list.inc.php';

    $index = 1;
    foreach ($corporateAgendas as $className) {
      $arr = [
        Card::FIELD_CARD_TYPE => CorporateAgendaCard::CARD_TYPE,
        Card::FIELD_CARD_TYPE_ARG => CorporateAgendaCard::CARD_TYPE_ARG,
        Card::FIELD_CARD_LOCATION => Card::LOCATION_DECK,
        Card::FIELD_CARD_LOCATION_ARG => $index++,
        Card::FIELD_CARD_NAME => $className::CARD_NAME,
        Card::FIELD_CARD_PROMOTERS => 0
      ];

      $card = $this->loadCardInstance($className::CARD_NAME, $arr);

      $this->cards[] = $card;
    }
  }
}