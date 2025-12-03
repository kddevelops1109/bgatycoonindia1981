<?php
namespace Bga\Games\tycoonindianew\Registry;

use Bga\Games\tycoonindianew\Condition\Condition;

class ConditionRegistry extends Registry {
  
  /**
   * Add given filter to the registry
   * @param string $key
   * @param Entry $entry
   * @throws \InvalidArgumentException
   * @return void
   */
  public function add(string $key, Entry $entry) {
      if (!$entry instanceof Condition) {
          throw new \InvalidArgumentException("ConditionRegistry only accepts Condition entries");
      }

      parent::add($key, $entry);
  }

  public function create(array $args): Condition {
    return new Condition($args["key"], $args["query"], $args["expectedResult"]);
  }
}