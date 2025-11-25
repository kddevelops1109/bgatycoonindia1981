<?php
namespace Bga\Games\tycoonindianew\DB\Query;

use Bga\Games\tycoonindianew\Util\DataUtil;

class UpdateDBQuery extends FilteredDBQuery {

  /**
   * Array of associative arrays for each column to update (with column name, data type and value)
   * @var array
   */
  protected $datas;

  public function __construct($table, $datas, $filter) {
    $this->datas = $datas;
    
    return parent::__construct($table, DBQuery::DB_OPERATION_UPDATE, $filter);
  }

  public function props(): array {
    return [
      'table' => $this->table,
      'datas' => $this->datas,
      'filter' => $this->filter
    ];
  }

  public function build(): string {
    $sqlComponents = [DBQuery::DB_OPERATION_UPDATE, DBQuery::encloseIdentifier($this->table), DBQuery::KEYWORD_SET];

    $updates = [];
    foreach ($this->datas as $data) {
      $column = strval($data["column"]);
      $dataType = strval($data["type"]);
      $value = DataUtil::getValue($data["value"], $dataType);

      if ($dataType == DataUtil::DATA_TYPE_STRING) {
        $updates[] = DBQuery::encloseIdentifier($column) . " = " . DBQuery::encloseStringValue(addslashes($value));
      }
      elseif ($dataType == DataUtil::DATA_TYPE_OBJ) {
        $updates[] = DBQuery::encloseIdentifier($column) . " = " . DBQuery::encloseStringValue(addslashes(json_encode($value)));
      }
      elseif ($dataType == DataUtil::DATA_TYPE_BOOL) {
        if ($value) {
          $updates[] = DBQuery::encloseIdentifier($column) . " = 1";
        }
        else {
          $updates[] = DBQuery::encloseIdentifier($column) . " = 0";
        }
      }
      else {
        $updates[] = DBQuery::encloseIdentifier($column) . " = " . $value;
      }
    }

    $sqlComponents[] = implode(", " , $updates);

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
        "datas" => $this->datas,
        "filter" => $this->filter->stringify()
      ],
      true
    );
  }
}