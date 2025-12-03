<?php
namespace Bga\Games\tycoonindianew\Manager\Card;

use Bga\GameFramework\Components\Deck;

use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\Manager\DBManager;
use Bga\Games\tycoonindianew\Manager\Manager;

use Bga\Games\tycoonindianew\Model\Card\Card;

use Bga\Games\tycoonindianew\Query\UpdateDBQuery;

use Bga\Games\tycoonindianew\Registry\FilterRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;
use Bga\Games\tycoonindianew\Type\DataType;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\JoinType;
use Bga\Games\tycoonindianew\Type\OperatorType;

use Bga\Games\tycoonindianew\Util\StringUtil;

#[\AllowDynamicProperties]
abstract class CardManager implements Manager {

  /**
   * Single instance per type of card
   * @var array<string, CardManager>
   */
  private static array $instances = [];

  /**
   * Card deck being managed by this manager
   * @var mixed
   */
  protected Deck $deck;

  /**
   * Card instances
   * @var array<Card>
   */
  protected array $cards;

  /**
   * Private constructor to prevent instantiation outside of using the instance method
   */
  private function __construct() {}

  /**
   * Get new/existing instance of cards manager of given type
   * @param CardType $type
   * @return CardManager
   */
  public static function instance(CardType $type): CardManager {
    $instance = null;
    if (array_key_exists($type->value, self::$instances)) {
      $instance = self::$instances[$type->value];
    }
    else {
      if ($type == CardType::CORPORATE_AGENDA) {
        $instance = new CorporateAgendaCardManager();
      }
      elseif ($type == CardType::POLICY) {
        $instance = new PolicyCardManager();
      }
      elseif ($type == CardType::INDUSTRY) {
        $instance = new IndustryCardManager();
      }
      elseif ($type == CardType::MERIT) {
        $instance = new MeritCardManager();
      }
      elseif ($type == CardType::PROMISSARY_NOTE) {
        $instance = new PromissaryNoteCardManager();
      }

      if (!is_null($instance)) {
        self::$instances[$type->value] = $instance;
      }
    }

    return $instance;
  }

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
   * Setup deck of cards of given type and type arg at given location. Use given filepath and classpath to obtain the specific cards to instantiate. Use additional args provided, if any
   * @param CardType $cardType Type of cards being setup
   * @param CardTypeArg $cardTypeArg Type arg of cards being setup
   * @param CardLocation $cardLocation Location to setup cards at
   * @param string $filepath Filepath of list of specific cards
   * @param string $classpath Classpath of specific card to instantiate
   * @return void
   */
  protected function setupDeck(CardType $cardType,
                               CardTypeArg $cardTypeArg,
                               CardLocation $cardLocation,
                               string $filepath,
                               string $classpath) {

    $this->deck = Game::get()->deckFactory->createDeck(Card::TABLE_NAME);
    $this->deck->init(Card::TABLE_NAME);

    $cards = [];
    for ($i = 0; $i < $cardTypeArg->numCards(); $i++) {
      $cards[] = [
        'type' => $cardType->value,
        'type_arg' => $cardTypeArg->value,
        'nbr' => 1
      ];
    }

    $this->deck->createCards($cards, $cardLocation->value);

    // Create new card instances, setup card names and shuffle the deck
    $this->createNewCardInstances($cardType, $cardTypeArg, $cardLocation, $filepath, $classpath);

    $searchKey = implode(
      "_",
      [RegistryKeyPrefix::SEARCH_CARD_IN_DECK->value, StringUtil::strSnakeCase($cardType->value), StringUtil::strSnakeCase($cardLocation->value)]
    );
    
    $this->setupCardNames(
      StringUtil::strSnakeCase($cardType->value),
      StringUtil::strSnakeCase($cardLocation->value),
      $searchKey
    );

    $this->deck->shuffle($cardLocation->value);
  }

  /**
   * Create new instances of cards of given type and type arg at given location. Use given filepath and classpath to obtain the specific cards to instantiate. Use additional args provided, if any
   * @param CardType $cardType Type of cards being setup
   * @param CardTypeArg $cardTypeArg Type arg of cards being setup
   * @param CardLocation $cardLocation Location to setup cards at
   * @param string $filepath Filepath of list of specific cards
   * @param string $classpath Classpath of specific card to instantiate
   * @return void
   */
  protected function createNewCardInstances(CardType $cardType,
                                            CardTypeArg $cardTypeArg,
                                            CardLocation $cardLocation,
                                            string $filepath,
                                            string $classpath) {
    // Load list of cards
    include_once dirname(__FILE__) . $filepath;

    $cardTypeName = $cardType->value;
    $cardClassName = str_replace(" ", "", $cardTypeName);

    if (in_array($cardTypeName, [CardType::INDUSTRY, CardType::POLICY, CardType::PLANNING_COMMISSION])) {
      $cardClassName = Card::CLASSPATH . $cardClassName . "\\" . $cardClassName . "\\Card";
    }
    else {
      $cardClassName = Card::CLASSPATH . $cardClassName . "\\Card";
    }

    $index = 1;
    foreach ($classNames as $className) {
      $className = $classpath . "\\$className";

      $args = [
        Card::FIELD_CARD_TYPE => $cardType->value,
        Card::FIELD_CARD_TYPE_ARG => $cardTypeArg->value,
        Card::FIELD_CARD_LOCATION => $cardLocation->value,
        Card::FIELD_CARD_LOCATION_ARG => $index++,
        Card::FIELD_CARD_PROMOTERS => 0
      ];

      $card = new $className([...$args, ...$className::staticFieldArgs()]);

      $this->cards[] = $card;
    }
  }

  protected function setupCardNames(string $cardType, string $cardLocation, string $searchKey) {
    $registry = FilterRegistry::instance();

    $search_card_type_filter = $registry->getOrCreate(
      RegistryKeyPrefix::SEARCH_CARD_TYPE->value . "_" . $cardType,
      [
        "type" => FilterType::SIMPLE,
        "column" => Card::COLUMN_CARD_TYPE,
        "dataType" => DataType::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => CardType::CORPORATE_AGENDA->value
      ]
    );

    $search_card_location_filter = $registry->getOrCreate(
      RegistryKeyPrefix::SEARCH_CARD_LOCATION->value . "_" . $cardLocation,
      [
        "type" => FilterType::SIMPLE,
        "column" => Card::COLUMN_CARD_LOCATION,
        "dataType" => DataType::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => $cardLocation
      ]
    );

    $index = 0;
    foreach ($this->cards as $card) {
      $search_card_location_arg_filter = $registry->getOrCreate(
        RegistryKeyPrefix::SEARCH_CARD_LOCATION_ARG->value . "_" . $index,
        [
          "type" => FilterType::SIMPLE,
          "column" => Card::COLUMN_CARD_LOCATION_ARG,
          "dataType" => DataType::INT,
          "operator" => OperatorType::EQUALS,
          "value" => $index
        ]
      );

      $filter_args = [
        "type" => FilterType::COMPOSITE,
        "join" => JoinType::AND,
        "filters" => [
          $search_card_type_filter,
          $search_card_location_filter,
          $search_card_location_arg_filter
        ]
      ];

      $searchKey .= "_" . $index++;

      $search_in_deck_filter = $registry->getOrCreate($searchKey, $filter_args);

      $datas = [
        ["column" => Card::COLUMN_CARD_NAME, "type" => DataType::STRING, "value" => $card->cardName]
      ];

      DBManager::execute(new UpdateDBQuery(Card::TABLE_NAME, $datas, $search_in_deck_filter));
    }
  }

  /**
   * Move the card with given id from given source location to the given target location
   * @param int $cardId ID of the card to move
   * @param CardLocation $target Target location of the card
   * @param int|null $cardLocationArg Location arg of the target
   * @return void
   */
  protected function move(int $cardId, CardLocation $targetLocation, ?int $targetLocationArg): void {
    $this->deck->moveCard($cardId, $targetLocation->value, $targetLocationArg);
  }
}