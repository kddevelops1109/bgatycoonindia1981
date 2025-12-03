<?php
namespace Bga\Games\tycoonindianew\Query;

use Bga\Games\tycoonindianew\Type\OperationType;

/**
 * Represents a database query that can be executed against the DB
 * @property string $table Table this query is operating on
 * @property OperationType $operation Type of operation, i.e. INSERT/SELECT/UPDATE/DELETE
 * @property string $sql SQL query built for given table, operation and data
 */
abstract class DBQuery {

  public function __construct($table, $operation) {
    $this->table = $table;
    $this->operation = $operation;
  }

  abstract public function props(): array;
  
  abstract public function build(): string;

  abstract public function stringify(): string;
}