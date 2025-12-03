<?php
namespace Bga\Games\tycoonindianew\Query;

use Bga\Games\tycoonindianew\Type\CharType;
use Bga\Games\tycoonindianew\Type\DataType as DT;
use Bga\Games\tycoonindianew\Type\KeywordType;
use Bga\Games\tycoonindianew\Type\OperationType;

use Bga\Games\tycoonindianew\Util\DataUtil;
use Bga\Games\tycoonindianew\Util\StringUtil;

class InsertDBQuery extends DBQuery {

  /**
   * Array of associative arrays for each column (with column name, data type and value)
   * @var array
   */
  protected $datas;

  public function __construct($table, $datas) {
    $this->datas = $datas;
    return parent::__construct($table, OperationType::INSERT->name);
  }

  public function props(): array {
    return [
      'table' => $this->table,
      'datas' => $this->datas
    ];
  }

  public function build(): string {
    $sqlComponents = [OperationType::INSERT->name, KeywordType::INTO->value, StringUtil::encloseDatabaseIdentifier($this->table)];

    $columns = [];
    $values = [];

    foreach ($this->datas as $data) {
      $column = strval($data["column"]);
      $dataType = $data["type"];
      $value = DataUtil::getValue($data["value"], $dataType);

      $columns[] = $column;
      
      if ($dataType == DT::STRING) {
        $values[] = StringUtil::encloseStringDatabaseValue($value);
      }
      elseif ($dataType == DT::OBJ) {
        $values[] = StringUtil::encloseStringDatabaseValue(json_encode($value));
      }
      elseif ($dataType == DT::BOOL) {
        if ($value) {
          $values[] = 1;
        }
        else {
          $values[] = 0;
        }
      }
      else {
        $values[] = $value;
      }
    }

    $sqlComponents[] = CharType::BRACKET_START->value . implode(", ", $columns) . CharType::BRACKET_END->value;
    $sqlComponents[] = KeywordType::VALUES->value;
    $sqlComponents[] = CharType::BRACKET_START->value . implode(", ", $values) . CharType::BRACKET_END->value;

    $this->sql = implode(" ", $sqlComponents);

    return $this->sql;
  }

  public function stringify(): string {
    return print_r(
      [
        "table" => $this->table,
        "operation" => $this->operation->name,
        "sql" => $this->sql,
        "datas" => print_r($this->datas, true)
      ],
      true
    );
  }
}