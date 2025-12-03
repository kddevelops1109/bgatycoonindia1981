<?php
namespace Bga\Games\tycoonindianew\Registry;

use Bga\Games\tycoonindianew\Filter\CompositeDBFilter;
use Bga\Games\tycoonindianew\Filter\DBFilter;
use Bga\Games\tycoonindianew\Filter\SimpleDBFilter;

use Bga\Games\tycoonindianew\Type\FilterType;

class FilterRegistry extends Registry {
  
  /**
   * Add given filter to the registry
   * @param string $key
   * @param Entry $entry
   * @throws \InvalidArgumentException
   * @return void
   */
  public function add(string $key, Entry $entry) {
      if (!$entry instanceof DBFilter) {
          throw new \InvalidArgumentException("FilterRegistry only accepts DBFilter entries");
      }

      parent::add($key, $entry);
  }

  public function create(array $args): DBFilter {
    // If the key type is simple, then it is a simple db filter
    if ($args['type'] === FilterType::SIMPLE) {
      return new SimpleDBFilter($args["column"], $args["dataType"], $args["operator"], $args["value"]);
    }
    else {
      return new CompositeDBFilter($args["join"], $args["filters"]);
    }
  }
}