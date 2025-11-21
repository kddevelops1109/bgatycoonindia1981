<?php
namespace Bga\Games\tycoonindianew\Managers;

use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\DB\Query\DBQuery;
use Bga\Games\tycoonindianew\DB\Query\DBQueryResult;
use Bga\Games\tycoonindianew\DB\Query\SelectDBQuery;

class DBManager {

  /**
   * Execute given query and return the results
   * @param DBQuery $query
   * @return DBQueryResult
   */
  public static function execute(DBQuery $query): DBQueryResult {
    if ($query instanceof SelectDBQuery) {
      return self::executeSelectQuery($query);
    }
    else {
      Game::DbQuery($query->build());
      return new DBQueryResult(DBQueryResult::STATUS_SUCCESS, null);
    }
  }

  private static function executeSelectQuery($query): DBQueryResult {
    $result = null;

    $props = $query->props();
    $sql = $query->build();

    if ($props != null) {
      $columns = $props["columns"];
      $bUnique = boolval($props["bUnique"]);
      $bAssociative = boolval($props["bAssociative"]);

      if (sizeof($columns) > 1) {
        if ($bUnique) {
          $result = Game::getObjectFromDB($sql);
        }
        else {
          if ($bAssociative) {
            $result = Game::getCollectionFromDB($sql, false);
          }
          else {
            $result = Game::getObjectListFromDB($sql, false);
          }
        }
      }
      else {
        if ($bUnique) {
          $result = Game::getUniqueValueFromDB($sql);
        }
        else {
          $result = Game::getObjectListFromDB($sql);
        }
      }
    }

    return new DBQueryResult(DBQueryResult::STATUS_SUCCESS, $result);
  }
}