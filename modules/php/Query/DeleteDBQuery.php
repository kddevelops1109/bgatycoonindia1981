<?php
namespace Bga\Games\tycoonindianew\Query;

class DeleteDBQuery extends FilteredDBQuery {

  public function __construct($table, $filter) {
    return parent::__construct($table, $filter, DBQuery::DB_OPERATION_DELETE);
  }

  public function props(): array {
    return [
      'table' => $this->table,
      'filter' => $this->filter
    ];
  }

  public function build(): string {
    $sqlComponents = [DBQuery::DB_OPERATION_DELETE, DBQuery::KEYWORD_FROM, DBQuery::encloseIdentifier($this->table)];

    if (!is_null($this->filter)) {
      $sqlComponents[] = DBQuery::KEYWORD_WHERE;
      $sqlComponents[] = $this->filter->build();
    }

    $this->sql = implode(" ", $sqlComponents);

    return $this->sql;
  }

  public function stringify(): string {
    return print_r(
      [
        "table" => $this->table,
        "operation" => $this->operation,
        "sql" => $this->sql,
        "filter" => $this->filter->stringify()
      ],
      true
    );
  }
}