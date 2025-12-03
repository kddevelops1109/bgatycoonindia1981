<?php
namespace Bga\Games\tycoonindianew\Query;

use Bga\Games\tycoonindianew\Filter\DBFilter;
use Bga\Games\tycoonindianew\Type\KeywordType;
use Bga\Games\tycoonindianew\Type\OperationType;
use Bga\Games\tycoonindianew\Type\OrderByDirection;
use Bga\Games\tycoonindianew\Util\StringUtil;

class SelectDBQuery extends FilteredDBQuery {

  /**
   * Column names to be selected
   * @var array
   */
  protected $columns = [];

  /**
   * Column to order by
   * @var string
   */
  protected $orderBy;

  /**
   * Direction of ordering (ASC/DESC)
   * @var OrderByDirection
   */
  protected OrderByDirection $direction;

  /**
   * Number of records to return (0 indicates no limit)
   * @var int
   */
  protected $limit;

  /**
   * Indicates if a unique or single value must be returned.
   * - If there is only a single column in this SELECT query, a single value is returned
   * - If there are multiple columns, a single associative array is returned, with values for all requested columns
   * @var bool
   */
  protected $bUniqueValue;

  /**
   * Indicates if in case of returning a list, should an associative array be returned or a simple array. Ignored if there is only one column, and bUniqueValue is true
   * @var bool
   */
  protected $bAssociative;

  public function __construct(string $table, array $columns, ?DBFilter $filter = null, ?string $orderBy = null, ?OrderByDirection $direction = null, ?int $limit = null, ?bool $bUniqueValue = false, ?bool $bAssociative = false) {
    $this->encloseColumns($columns);
    
    $this->orderBy = $orderBy;
    $this->direction = $direction;
    $this->limit = $limit;
    $this->bUniqueValue = $bUniqueValue;
    $this->bAssociative = $bAssociative;
    
    return parent::__construct($table, OperationType::SELECT->name, $filter);
  }

  private function encloseColumns($columns) {
    $this->columns = [];
    foreach ($columns as $column) {
      $this->columns[] = StringUtil::encloseDatabaseIdentifier($column);
    }
  }

  public function props(): array {
    return [
      'table' => $this->table,
      'filter' => $this->filter,
      'columns' => $this->columns,
      'orderBy' => $this->orderBy,
      'direction' => $this->direction,
      'limit' => $this->limit,
      'bUniqueValue' => $this->bUniqueValue,
      'bAssociative' => $this->bAssociative
    ];
  }

  public function build(): string {
    $sqlComponents = [
      OperationType::SELECT->name,
      implode(", ", $this->columns),
      KeywordType::FROM->value,
      StringUtil::encloseDatabaseIdentifier($this->table)
    ];

    if (!is_null($this->filter)) {
      $sqlComponents[] = KeywordType::WHERE->value;
      $sqlComponents[] = $this->filter->build();
    }

    if (!is_null($this->orderBy)) {
      $sqlComponents[] = KeywordType::ORDER_BY->value;
      $sqlComponents[] = StringUtil::encloseDatabaseIdentifier($this->orderBy);

      if (is_null($this->direction)) {
        $sqlComponents[] = OrderByDirection::ASC;
      }
      else {
        $sqlComponents[] = $this->direction;
      }

      if (!is_null($this->limit)) {
        $sqlComponents[] = strval($this->limit);
      }
    }

    $this->sql = implode(" ", $sqlComponents);

    return $this->sql;
  }

  public function stringify(): string {
    return print_r(
      [
        "table" => $this->table,
        "operation" => $this->operation->name,
        "sql" => $this->sql,
        "columns" => print_r($this->columns, true),
        "orderBy" => $this->orderBy,
        "direction" => $this->direction->name,
        "limit" => $this->limit,
        "bUniqueValue" => $this->bUniqueValue,
        "bAssociative" => $this->bAssociative,
        "filter" => $this->filter->stringify()
      ],
      true
    );
  }
}