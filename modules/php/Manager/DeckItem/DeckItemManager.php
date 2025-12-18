<?php
namespace Bga\Games\tycoonindianew\Manager\DeckItem;

use Bga\Games\tycoonindianew\Manager\Manager;

abstract class DeckItemManager implements Manager {

  /**
   * Single instance per class of specific deck item manager
   * @var array<class-string, static>
   */
  protected static array $instances = [];

  /**
   * Deck being managed by this manager
   * @var array<string, Deck>
   */
  protected array $decks;

   /**
   * Private constructor to prevent instantiation outside of using the instance method
   */
  protected function __construct() {}

  /**
   * Get new/existing instance of deck item manager of given type
   * @return static
   */
  public static function instance(): static {
    $class = static::class;
    if (!array_key_exists($class, self::$instances)) {
      self::$instances[$class] = new static();
    }

    return self::$instances[$class];
  }

  /************************************************************************************************************************************************/
  /************************************************************ ABSTRACT METHODS ******************************************************************/
  /************************************************************************************************************************************************/

  /**
   * Handles setting up of deck during game setup, for the specific deck item manager subclass on which this is being called
   * @param array $players Array of players sent from Game as part of standard game setup
   * @return void
   */
  abstract public function setupNewGame(array $players);

  /**
   * Setup new deck of specific deck items
   * @return void
   */
  abstract protected function setupNewDeck();

  
}