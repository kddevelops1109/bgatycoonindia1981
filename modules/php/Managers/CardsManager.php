<?php
namespace Bga\Games\tycoonindianew\Managers;

use Bga\Games\tycoonindianew\Models\Cards\Card;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;

abstract class CardsManager {

  /**
   * Single instance per type of card
   * @var array
   */
  private static $instances = [];

  /**
   * Card deck being managed by this manager
   * @var mixed
   */
  protected $deck;

  /**
   * Card instances
   * @var array
   */
  protected $cards;

  /**
   * Private constructor to prevent instantiation outside of using the getInstance method
   */
  private function __construct() {}

  /**
   * Get new/existing instance of cards manager of given type
   * @param string $type
   * @return CardsManager
   */
  public static function getInstance(string $type): CardsManager {
    $instance = null;
    if (array_key_exists($type, self::$instances)) {
      $instance = self::$instances[$type];
    }
    else {
      if ($type == CorporateAgendaCard::CARD_TYPE) {
        $instance = new CorporateAgendaCardsManager();
      }
      elseif ($type == self::CARD_TYPE_POLICY) {
        $instance = new PolicyCardsManager();
      }
      elseif ($type == self::CARD_TYPE_INDUSTRY) {
        $instance = new IndustryCardsManager();
      }
      elseif ($type == self::CARD_TYPE_MERIT) {
        $instance = new MeritCardsManager();
      }
      elseif ($type == self::CARD_TYPE_PROMISSARY_NOTE) {
        $instance = new PromissaryNoteCardsManager();
      }

      if (!is_null($instance)) {
        self::$instances[$type] = $instance;
      }
    }

    return $instance;
  }

  /**
   * Loads new card instance for given card class name
   * @param string $cardName Name of card
   * @param array $arr Array representing card data
   * @return Card
   */
  abstract protected function loadCardInstance(string $cardName, array $arr): Card;

  /**
   * Handles setting up of cards deck during game setup, for the specific cards manager subclass on which this is being called
   * @param array $players Array of players sent from Game as part of standard game setup
   * @return void
   */
  abstract public function setupNewGame(array $players);

  /**
   * Setup new deck of cards for given card type
   * @return void
   */
  abstract protected function setupNewDeck();

  /**
   * Constants - Card type
   */
  const CARD_TYPE_POLICY = "Policy";
  const CARD_TYPE_INDUSTRY = "Industry";
  const CARD_TYPE_MERIT = "Merit";
  const CARD_TYPE_PROMISSARY_NOTE = "Promissary Note";
}