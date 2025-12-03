<?php
namespace Bga\Games\tycoonindianew\Query;

use Bga\Games\tycoonindianew\Type\KeywordType;
use Bga\Games\tycoonindianew\Type\OperationType;
use Bga\Games\tycoonindianew\Util\StringUtil;

class DeleteDBQuery extends FilteredDBQuery {

  public function __construct($table, $filter) {
    return parent::__construct($table, $filter, OperationType::DELETE);
  }

  public function props(): array {
    return [
      'table' => $this->table,
      'filter' => $this->filter
    ];
  }

  public function build(): string {
    $sqlComponents = [OperationType::DELETE->name, KeywordType::FROM->value, StringUtil::encloseDatabaseIdentifier($this->table)];

    if (!is_null($this->filter)) {
      $sqlComponents[] = KeywordType::WHERE->value;
      $sqlComponents[] = $this->filter->build();
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
        "filter" => $this->filter->stringify()
      ],
      true
    );
  }
}