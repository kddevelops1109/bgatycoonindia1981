<?php
namespace Bga\Games\tycoonindianew\Query;

use Bga\Games\tycoonindianew\Filter\DBFilter;

abstract class FilteredDBQuery extends DBQuery {

  /**
   * Represents a DB filter
   * @var DBFilter
   */
  protected DBFilter $filter;

  public function __construct($table, $operation, $filter) {
    $this->filter = $filter;
    return parent::__construct($table, $operation);
  }
  
  abstract public function props(): array;

  abstract public function build(): string;

  abstract public function stringify(): string;
}