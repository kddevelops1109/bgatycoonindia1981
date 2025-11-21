<?php
namespace Bga\Games\tycoonindianew\DB\Query;

use Bga\Games\tycoonindianew\Util\DataUtil;

class InsertDBQuery extends DBQuery {

  /**
   * Array of associative arrays for each column (with column name, data type and value)
   * @var array
   */
  protected $datas;

  public function __construct($table, $datas) {
    $this->datas = $datas;
    return parent::__construct($table, DBQuery::DB_OPERATION_INSERT);
  }

  public function props(): array {
    return [
      'table' => $this->table,
      'datas' => $this->datas
    ];
  }

  public function build(): string {
    $sqlComponents = [DBQuery::DB_OPERATION_INSERT, DBQuery::KEYWORD_INTO, DBQuery::encloseIdentifier($this->table)];

    $columns = [];
    $values = [];

    foreach ($this->datas as $data) {
      $column = strval($data["column"]);
      $dataType = strval($data["type"]);
      $value = DataUtil::getValue($data["value"], $dataType);

      $columns[] = $column;
      
      if ($dataType == DataUtil::DATA_TYPE_STRING["name"]) {
        $values[] = addslashes($value);
      }
      elseif ($dataType == DataUtil::DATA_TYPE_OBJ["name"]) {
        $values[] = addslashes(json_encode($value));
      }
      else {
        $values[] = $value;
      }
    }

    $sqlComponents[] = DBQuery::CHAR_BRACKET_START . implode(", ", $columns) . DBQuery::CHAR_BRACKET_END;
    $sqlComponents[] = DBQuery::KEYWORD_VALUES;
    $sqlComponents[] = DBQuery::CHAR_BRACKET_START . implode(", ", $values) . DBQuery::CHAR_BRACKET_END;

    $this->sql = implode(" ", $sqlComponents);

    return $this->sql;
  }

  public function stringify(): string {
    return print_r(
      [
        "table" => $this->table,
        "operation" => $this->operation,
        "sql" => $this->sql,
        "datas" => print_r($this->datas, true)
      ],
      true
    );
  }
}