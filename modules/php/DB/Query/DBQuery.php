<?php
namespace Bga\Games\tycoonindianew\DB\Query;

abstract class DBQuery {

  /**
   * Table this query is operating on
   * @var string
   */
  protected $table;

  /**
   * Type of operation, i.e. INSERT/SELECT/UPDATE/DELETE
   * @var string
   */
  protected $operation;

  /**
   * SQL query built for given table, operation and data
   * @var string
   */
  protected $sql;

  public function __construct($table, $operation) {
    $this->table = $table;
    $this->operation = $operation;
  }

  /**
   * Enclose the given identifier within backtick character
   * @param string $identifier
   * @return string
   */
  public static function encloseIdentifier(string $identifier) {
    return self::CHAR_BACKTICK . $identifier . self::CHAR_BACKTICK;
  }

  /**
   * Enclose the given value within single quotes
   * @param string $value
   * @return string
   */
  public static function encloseStringValue(string $value) {
    return self::CHAR_SINGLE_QUOTE . $value . self::CHAR_SINGLE_QUOTE;
  }

  abstract public function props(): array;
  
  abstract public function build(): string;

  abstract public function stringify(): string;

  /**
   * Constants - DB Operations
  */

  const DB_OPERATION_INSERT = 'INSERT';
  const DB_OPERATION_SELECT = 'SELECT';
  const DB_OPERATION_UPDATE = 'UPDATE';
  const DB_OPERATION_DELETE = 'DELETE';

  /**
   * Constants - Keywords
   */
  const KEYWORD_INTO = 'INTO';
  const KEYWORD_VALUES = 'VALUES';
  const KEYWORD_FROM = 'FROM';
  const KEYWORD_WHERE = 'WHERE';
  const KEYWORD_SET = 'SET';
  const KEYWORD_ORDER_BY = 'ORDER BY';
  const KEYWORD_LIMIT = 'LIMIT';

  /**
   * Constants - Special characters
   */

  const CHAR_BACKTICK = '`';
  const CHAR_SINGLE_QUOTE = "'";
  const CHAR_BRACKET_START = '(';
  const CHAR_BRACKET_END = ')';
}