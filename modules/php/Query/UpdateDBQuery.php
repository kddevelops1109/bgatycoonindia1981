<?php
namespace Bga\Games\tycoonindianew\Query;

use Bga\Games\tycoonindianew\Type\DataType;
use Bga\Games\tycoonindianew\Type\KeywordType;
use Bga\Games\tycoonindianew\Type\OperationType;

use Bga\Games\tycoonindianew\Util\DataUtil;
use Bga\Games\tycoonindianew\Util\StringUtil;

class UpdateDBQuery extends FilteredDBQuery {

  /**
   * Array of associative arrays for each column to update (with column name, data type and value)
   * @var array
   */
  protected $datas;

  public function __construct($table, $datas, $filter) {
    $this->datas = $datas;
    
    return parent::__construct($table, OperationType::UPDATE->name, $filter);
  }

  public function props(): array {
    return [
      'table' => $this->table,
      'datas' => $this->datas,
      'filter' => $this->filter
    ];
  }

  public function build(): string {
    $sqlComponents = [OperationType::UPDATE->name, StringUtil::encloseDatabaseIdentifier($this->table), KeywordType::SET->value];

    $updates = [];
    foreach ($this->datas as $data) {
      $column = strval($data["column"]);
      $dataType = $data["type"];
      $value = DataUtil::getValue($data["value"], $dataType);

      if ($dataType == DataType::STRING) {
        $updates[] = StringUtil::encloseDatabaseIdentifier($column) . " = " . StringUtil::encloseStringDatabaseValue(addslashes($value));
      }
      elseif ($dataType == DataType::OBJ) {
        $updates[] = StringUtil::encloseDatabaseIdentifier($column) . " = " . StringUtil::encloseStringDatabaseValue(addslashes(json_encode($value)));
      }
      elseif ($dataType == DataType::BOOL) {
        if ($value) {
          $updates[] = StringUtil::encloseDatabaseIdentifier($column) . " = 1";
        }
        else {
          $updates[] = StringUtil::encloseDatabaseIdentifier($column) . " = 0";
        }
      }
      else {
        $updates[] = StringUtil::encloseDatabaseIdentifier($column) . " = " . $value;
      }
    }

    $sqlComponents[] = implode(", " , $updates);

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
        "datas" => $this->datas,
        "filter" => $this->filter->stringify()
      ],
      true
    );
  }
}