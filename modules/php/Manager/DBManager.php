<?php
namespace Bga\Games\tycoonindianew\Manager;

use Bga\Games\tycoonindianew\Game;

use Bga\Games\tycoonindianew\Query\DBQuery;
use Bga\Games\tycoonindianew\Query\DBQueryResult;
use Bga\Games\tycoonindianew\Query\SelectDBQuery;
use Bga\Games\tycoonindianew\Type\QueryStatus;

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
      return new DBQueryResult(QueryStatus::SUCCESS, null);
    }
  }

  private static function executeSelectQuery(DBQuery $query): DBQueryResult {
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

    return new DBQueryResult(QueryStatus::SUCCESS, $result);
  }
}