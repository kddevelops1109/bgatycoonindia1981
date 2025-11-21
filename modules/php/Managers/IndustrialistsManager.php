<?php
namespace Bga\Games\tycoonindianew\Managers;

use BGA\Games\tycoonindianew\DB\Filter\DBFilter;
use Bga\Games\tycoonindianew\DB\Filter\SimpleDBFilter;
use Bga\Games\tycoonindianew\DB\Query\DBQuery;
use Bga\Games\tycoonindianew\Game;
use Bga\Games\tycoonindianew\Models\Industrialist;
use Bga\Games\tycoonindianew\Util\DataUtil;
use BgaVisibleSystemException;

class IndustrialistsManager {

  /**
   * Array of industrialists
   * @var array
   */
  protected static $industrialists = [];

  /*********************************************************************************************/
  /***************************************NEW GAME SETUP****************************************/
  /*********************************************************************************************/
  
  /**
   * Setup industrialists at the start of a new game for given players
   * @param array $players
   * @return void
   */
  public static function setupNewGame($players) {
    foreach ($players as $player_id => $player) {
      $player_no = intval(Game::get()->getPlayerNoById($player_id));
      $player_name = strval(Game::get()->getPlayerNameById($player_id));
      $player_color = strval(Game::get()->getPlayerColorById($player_id));

      $arr = [
        'id' => $player_id,
        'no' => $player_no,
        'name' => $player_name,
        'color' => $player_color,
        'colorName' => self::COLOR_NAMES[$player_color],
        'eliminated' => false,
        'score' => 0,
        'scoreAux' => 0,
        'zombie' => 0,
        'isTycoon' => $player_no == 1,
        'isNextTycoon' => false,
        'influence' => self::setupInfluence($player_no),
        'influenceRank' => 1,
        'assetValue' => 0,
        'favor' => 0,
        'money' => self::setupMoney($player_no),
        'promotersInHand' => self::setupPromotersInHand($player_no),
        'promotersInPool' => 0,
        'promissaryNotes' => 0,
        'loanIntakeLevel' => 30,
        'finance' => 0,
        'financeRank' => 0,
        'minerals' => 0,
        'mineralsRank' => 0,
        'fuel' => 0,
        'fuelRank' => 0,
        'agro' => 0,
        'agroRank' => 0,
        'power' => 0,
        'powerRank' => 0,
        'transport' => 0,
        'transportRank' => 0,
        'actionsRemaining' => 2,
        'plusOneActionsRemaining' => 0,
        'tycoonActionsRemaining' => $player_no == 1 ? 1 : 0
      ];

      $industrialist = new Industrialist($arr);
      self::$industrialists[] = $industrialist;

      $operator = SimpleDBFilter::OPERATOR_EQUALS;

      // Update player data in db
      $industrialist->update($arr, new SimpleDBFilter(Industrialist::COLUMN_PLAYER_ID, DataUtil::DATA_TYPE_INT["name"], $operator, $player_id));
    }
  }

  /**
   * Return initial setup influence for player
   * @param int $player_no
   * @return int
   */
  private static function setupInfluence(int $player_no): int {
    return Game::get()->getPlayersNumber() + 1 - $player_no;
  }

  /**
   * Return initial setup money for player
   * @param int $player_no
   * @return int
   */
  private static function setupMoney(int $player_no) {
    return $player_no == 1 ? self::STARTING_MONEY_TYCOON : self::STARTING_MONEY;
  }

  /**
   * Summary of setupPromotersInHand
   * @param int $player_no
   * @return int
   */
  private static function setupPromotersInHand(int $player_no): int {
    return 7 - self::setupInfluence($player_no);
  }

  const COLOR_NAMES = ["a24341" => "red", "2f6534" => "green", "3a7094" => "blue", "bea227" => "yellow"];

  const STARTING_MONEY = 150;
  const STARTING_MONEY_TYCOON = 130;
  const STARTING_LOAN_INTAKE_LEVEL = 30;
}