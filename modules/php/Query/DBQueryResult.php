<?php
namespace Bga\Games\tycoonindianew\Query;

use Bga\Games\tycoonindianew\Type\QueryStatus;

class DBQueryResult {

  /**
   * Query execution status - success/error
   * @var QueryStatus
   */
  protected QueryStatus $status;

  /**
   * Result of the query execution.
   * - This is null in case of INSERT, UPDATE and DELETE operations
   * - This is a mixed value (cane be an int/string/bool/obj/array)
   * @var mixed
   */
  protected $result;

  public function __construct($status, $result) {
    $this->status = $status;
    $this->result = $result;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getResult() {
    return $this->result;
  }
}