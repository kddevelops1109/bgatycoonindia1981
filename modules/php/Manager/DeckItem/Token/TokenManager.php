<?php
namespace Bga\Games\tycoonindianew\Manager\DeckItem\Token;

use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\Manager\DBManager;
use Bga\Games\tycoonindianew\Manager\DeckItem\DeckItemManager;

use Bga\Games\tycoonindianew\Model\DeckItem\DeckItem;
use Bga\Games\tycoonindianew\Model\DeckItem\Token\Token;

use Bga\Games\tycoonindianew\Query\UpdateDBQuery;

use Bga\Games\tycoonindianew\Registry\FilterRegistry;
use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;

use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\JoinType;
use Bga\Games\tycoonindianew\Type\OperatorType;
use Bga\Games\tycoonindianew\Type\TokenLocation;
use Bga\Games\tycoonindianew\Type\TokenType;
use Bga\Games\tycoonindianew\Type\TokenTypeArg;

use Bga\Games\tycoonindianew\Util\StringUtil;

abstract class TokenManager extends DeckItemManager {

  /**
   * Token instances
   * @var array<Token>
   */
  protected array $tokens;

  /**
   * Setup deck of tokens of given type and type arg at given location. Use given filepath and classpath to obtain the specific tokens to instantiate. Use additional args provided, if any
   * @param TokenType $tokenType Type of tokens being setup
   * @param TokenTypeArg $tokenTypeArg Type arg of tokens being setup
   * @param TokenLocation $tokenLocation Location to setup tokens at
   * @param string $filepath Filepath of list of specific tokens
   * @param string $classpath Classpath of specific token to instantiate
   * @param bool $shuffle Should this deck be shuffled on setup (defaults to true)
   * @return void
   */
  protected function setupDeck(TokenType $tokenType, TokenTypeArg $tokenTypeArg, TokenLocation $tokenLocation, string $filepath, string $classpath, bool $shuffle = true) {
    $deck = Game::get()->deckFactory->createDeck(Token::TABLE_NAME);
    $deck->init(Token::TABLE_NAME);

    $tokens = [];

    // Load list of tokens
    include dirname(__FILE__) . $filepath;

    foreach ($classNames as $className) {
      $className = $classpath . "\\$className";
      $tokens[] = [
        'type' => $tokenType->value,
        'type_arg' => $tokenTypeArg->value,
        'nbr' => $className::NBR
      ];
    }

    $deck->createCards($tokens, $tokenLocation->value);

    // Create new token instances, setup token names and shuffle the deck
    $this->createNewTokenInstances($tokenType, $tokenTypeArg, $tokenLocation, $filepath, $classpath);

    $searchKey = implode("_", [RegistryKeyPrefix::SEARCH_TOKEN_IN_DECK->value, StringUtil::strSnakeCase($tokenType->value), StringUtil::strSnakeCase($tokenLocation->value)]);

    $this->setupTokenNames($tokenType, $tokenLocation, $searchKey, $filepath, $classpath);

    if ($shuffle) {
      $deck->shuffle($tokenLocation->value);
    }

    $deckIdentity = StringUtil::strToKebab($tokenType->value) . "-" . StringUtil::strToKebab($tokenLocation->value);

    $this->decks[$deckIdentity] = $deck;
  }

  /**
   * Create new instances of tokens of given type and type arg at given location. Use given filepath and classpath to obtain the specific tokens to instantiate. Use additional args provided, if any
   * @param TokenType $tokenType Type of tokens being setup
   * @param TokenTypeArg $tokenTypeArg Type arg of tokens being setup
   * @param TokenLocation $tokenLocation Location to setup tokens at
   * @param string $filepath Filepath of list of specific tokens
   * @param string $classpath Classpath of specific token to instantiate
   * @return void
   */
  protected function createNewTokenInstances(TokenType $tokenType, TokenTypeArg $tokenTypeArg, TokenLocation $tokenLocation, string $filepath, string $classpath) {
    // Load list of tokens
    include dirname(__FILE__) . $filepath;

    $index = 1;
    foreach ($classNames as $className) {
      $className = $classpath . "\\$className";

      $args = [
        ...[
          DeckItem::FIELD_ITEM_TYPE => $tokenType->value,
          DeckItem::FIELD_ITEM_TYPE_ARG => $tokenTypeArg->value,
          DeckItem::FIELD_ITEM_LOCATION => $tokenLocation->value,
          DeckItem::FIELD_ITEM_LOCATION_ARG => $index++,
          DeckItem::FIELD_ITEM_NAME => $className::NAME
        ],
        ...$className::staticFieldArgs()
      ];

      $token = new $className($args);

      $this->tokens[] = $token;
    }
  }

  protected function setupTokenNames(TokenType $tokenType, TokenLocation $tokenLocation, string $searchKey, string $filepath, string $classpath) {
    $registry = FilterRegistry::instance();

    $search_token_type_filter = $registry->getOrCreate(
      RegistryKeyPrefix::SEARCH_TOKEN_TYPE->value . "_" . StringUtil::strSnakeCase($tokenType->value),
      [
        "type" => FilterType::SIMPLE,
        "column" => DeckItem::COLUMN_ITEM_TYPE,
        "dataType" => DT::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => $tokenType->value
      ]
    );

    $search_token_location_filter = $registry->getOrCreate(
      RegistryKeyPrefix::SEARCH_TOKEN_LOCATION->value . "_" . StringUtil::strSnakeCase($tokenLocation->value),
      [
        "type" => FilterType::SIMPLE,
        "column" => DeckItem::COLUMN_ITEM_LOCATION,
        "dataType" => DT::STRING,
        "operator" => OperatorType::EQUALS,
        "value" => $tokenLocation->value
      ]
    );

    $index = 1;
    // Load list of tokens
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
      $tokenName = $className::NAME;

      $search_token_location_arg_filter = $registry->getOrCreate(
        RegistryKeyPrefix::SEARCH_TOKEN_LOCATION_ARG->value . "_" . $index,
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
          $search_token_type_filter,
          $search_token_location_filter,
          $search_token_location_arg_filter
        ]
      ];

      $searchKey .= "_" . $index++;

      $search_in_deck_filter = $registry->getOrCreate($searchKey, $filter_args);

      $datas = [
        ["column" => DeckItem::COLUMN_ITEM_NAME, "type" => DT::STRING, "value" => $tokenName]
      ];

      DBManager::execute(new UpdateDBQuery(Token::TABLE_NAME, $datas, $search_in_deck_filter));
    }
  }

  /**
   * Move the token with given id from given source location to the given target location
   * @param int $tokenId ID of the token to move
   * @param TokenLocation $target Target location of the token
   * @param int|null $tokenLocationArg Location arg of the target
   * @return void
   */
  protected function move(int $tokenId, TokenLocation $targetLocation, ?int $targetLocationArg): void {
    // $this->deck->moveToken($tokenId, $targetLocation->value, $targetLocationArg);
  }
}