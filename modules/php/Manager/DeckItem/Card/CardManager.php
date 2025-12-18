<?php
namespace Bga\Games\tycoonindianew\Manager\DeckItem\Card;

use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\Manager\DBManager;
use Bga\Games\tycoonindianew\Manager\DeckItem\DeckItemManager;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Card;
use Bga\Games\tycoonindianew\Model\DeckItem\DeckItem;
use Bga\Games\tycoonindianew\Query\UpdateDBQuery;

use Bga\Games\tycoonindianew\Registry\FilterRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardType;
use Bga\Games\tycoonindianew\Type\CardTypeArg;
use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\JoinType;
use Bga\Games\tycoonindianew\Type\OperatorType;

use Bga\Games\tycoonindianew\Util\StringUtil;

#[\AllowDynamicProperties]
abstract class CardManager extends DeckItemManager {

  /**
   * Card instances
   * @var array<Card>
   */
  protected array $cards;

  /**
   * Setup deck of cards of given type and type arg at given location. Use given filepath and classpath to obtain the specific cards to instantiate. Use additional args provided, if any
   * @param CardType $cardType Type of cards being setup
   * @param CardTypeArg $cardTypeArg Type arg of cards being setup
   * @param CardLocation $cardLocation Location to setup cards at
   * @param string $filepath Filepath of list of specific cards
   * @param string $classpath Classpath of specific card to instantiate
   * @param bool $shuffle Should this deck be shuffled on setup (defaults to true)
   * @return void
   */
  protected function setupDeck(CardType $cardType, CardTypeArg $cardTypeArg, CardLocation $cardLocation, string $filepath, string $classpath, bool $shuffle = true) {
    $deck = Game::get()->deckFactory->createDeck(Card::TABLE_NAME);
    $deck->init(Card::TABLE_NAME);

    $cards = [];

    // Load list of cards
    include dirname(__FILE__) . $filepath;

    foreach ($classNames as $className) {
      $className = $classpath . "\\$className";
      $cards[] = [
        'type' => $cardType->value,
        'type_arg' => $cardTypeArg->value,
        'nbr' => $className::NBR
      ];
    }

    $deck->createCards($cards, $cardLocation->value);

    // Create new card instances, setup card names and shuffle the deck
    $this->createNewCardInstances($cardType, $cardTypeArg, $cardLocation, $filepath, $classpath);

    $searchKey = implode("_", [RegistryKeyPrefix::SEARCH_CARD_IN_DECK->value, StringUtil::strSnakeCase($cardType->value), StringUtil::strSnakeCase($cardLocation->value)]);

    $this->setupCardNames($cardType, $cardLocation, $searchKey, $filepath, $classpath);

    if ($shuffle) {
      $deck->shuffle($cardLocation->value);
    }

    $deckIdentity = StringUtil::strToKebab($cardType->value) . "-" . StringUtil::strToKebab($cardLocation->value);

    $this->decks[$deckIdentity] = $deck;
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
  protected function createNewCardInstances(CardType $cardType, CardTypeArg $cardTypeArg, CardLocation $cardLocation, string $filepath, string $classpath) {
    // Load list of cards
    include dirname(__FILE__) . $filepath;

    $index = 1;
    foreach ($classNames as $className) {
      $className = $classpath . "\\$className";

      $args = [
        ...[
          DeckItem::FIELD_ITEM_TYPE => $cardType->value,
          DeckItem::FIELD_ITEM_TYPE_ARG => $cardTypeArg->value,
          DeckItem::FIELD_ITEM_LOCATION => $cardLocation->value,
          DeckItem::FIELD_ITEM_LOCATION_ARG => $index++,
          DeckItem::FIELD_ITEM_NAME => $className::NAME,
          Card::FIELD_PROMOTERS => 0
        ],
        ...$className::staticFieldArgs()
      ];

      $card = new $className($args);

      $this->cards[] = $card;
    }
  }

  protected function setupCardNames(CardType $cardType, CardLocation $cardLocation, string $searchKey, string $filepath, string $classpath) {
    $registry = FilterRegistry::instance();

    $search_card_type_filter = $registry->getOrCreate(
      RegistryKeyPrefix::SEARCH_CARD_TYPE->value . "_" . StringUtil::strSnakeCase($cardType->value),
      [
        "type" => FilterType::SIMPLE,
        "column" => DeckItem::COLUMN_ITEM_TYPE,
        "dataType" => DT::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => $cardType->value
      ]
    );

    $search_card_location_filter = $registry->getOrCreate(
      RegistryKeyPrefix::SEARCH_CARD_LOCATION->value . "_" . StringUtil::strSnakeCase($cardLocation->value),
      [
        "type" => FilterType::SIMPLE,
        "column" => DeckItem::COLUMN_ITEM_LOCATION,
        "dataType" => DT::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => $cardLocation->value
      ]
    );

    $index = 1;
    // Load list of cards
    include dirname(__FILE__) . $filepath;

    $finalClassNames = [];

    foreach ($classNames as $className) {
      $className = $classpath . "\\$className";

      for ($i = 0; $i < $className::NBR; $i++) {
        $finalClassNames[] = $className;
      }
    }

    shuffle($finalClassNames);

    foreach ($finalClassNames as $className) {
      $cardName = $className::NAME;

      $search_card_location_arg_filter = $registry->getOrCreate(
        RegistryKeyPrefix::SEARCH_CARD_LOCATION_ARG->value . "_" . $index,
        [
          "type" => FilterType::SIMPLE,
          "column" => DeckItem::COLUMN_ITEM_LOCATION_ARG,
          "dataType" => DT::INT,
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
        ["column" => DeckItem::COLUMN_ITEM_NAME, "type" => DT::STRING, "value" => $cardName]
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
    // $this->deck->moveCard($cardId, $targetLocation->value, $targetLocationArg);
  }
}