<?php
namespace Bga\Games\tycoonindianew\DB\Query;

class DBQueryResult {

  /**
   * Query execution status - success/error
   * @var string
   */
  protected $status;

  /**
   * Result of the query execution.
   * - This is null in case of INSERT, UPDATE and DELETE operations
   * - This is a mixed value (cane be an int/string/bool/obj/array)
   * @var mixed
   */
  protected $result;

  public function __construct($status, $result) {
    $this->$status = $status;
    $this->result = $result;
  }

  /**
   * Constants - Status
   */

  const STATUS_SUCCESS = "success";
  const STATUS_ERROR = "error";
}