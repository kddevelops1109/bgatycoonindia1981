<?php
namespace Bga\Games\tycoonindianew\Manager;

class CityManager implements Manager {

  /**
   * Singleton instance of the City manager
   * @var CityManager|null
   */
  private static ?CityManager $instance = null;

  private function __construct() {
    // Empty private constructor for singleton instance creation
  }

  /**
   * Get (or create and get) singleton instance of City Manager
   * @return CityManager
   */
  public static function instance(): CityManager {
    if (self::$instance == null) {
      self::$instance = new CityManager();
    }

    return self::$instance;
  }

  /**
   * New game setup of cities
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players){
    // Load list of cities
    include dirname(__FILE__) . self::FILEPATH;

    // Iterate through class names and instantiate cities
    foreach ($classNames as $className) {
      $className = self::CLASSPATH . "\\" . $className;
      
      $args = [$className::FIELD_OCCUPIED => false];

      $className::getOrCreate($args)->insert();
    }
  }

  /** Constants - Misc */
  const FILEPATH = "/../City/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\City";
}