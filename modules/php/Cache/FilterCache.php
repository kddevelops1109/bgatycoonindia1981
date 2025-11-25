<?php
namespace Bga\Games\tycoonindianew\Cache;

use Bga\Games\tycoonindianew\Filter\DBFilter;
use Bga\Games\tycoonindianew\Filter\SimpleDBFilter;

/**
 * Singleton cache of commonly used filters
 */
class FilterCache {

  /**
   * Array of filters
   * @var array
   */
  protected array $cache;

  private static $instance;

  private function __construct() {
    // Private to ensure the filter cache is a singleton instance
    $this->cache = [];
  }

  public static function getInstance() {
    if (is_null(self::$instance)) {
      self::$instance = new FilterCache();
    }

    return self::$instance;
  }

  public function findByKey(string $key): DBFilter|null {
    $filter = null;
    if (array_key_exists($key, $this->cache)) {
      $filter = $this->cache[$key];
    }

    return $filter;
  }

  public function getSimpleCachedFilter(string $key, string $column, string $dataType, string $operator, $value): SimpleDBFilter {
    return $this->findByKey($key) ?: $this->createAndCacheSimpleFilter($key, $column, $dataType, $operator, $value);
  }

  protected function createAndCacheSimpleFilter(string $key, string $column, string $dataType, string $operator, $value): SimpleDBFilter {
    $filter = new SimpleDBFilter($column, $dataType, $operator, $value);
    $this->cache[$key] = $filter;

    return $filter;
  }

  /**
   * Constants - Cache keys
   */
  const KEY_PLAYER_ID_SEARCH = "player_id_search";
}