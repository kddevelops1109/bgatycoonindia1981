<?php
namespace Bga\Games\tycoonindianew\Filter;

use Bga\Games\tycoonindianew\Type\CharType;
use Bga\Games\tycoonindianew\Type\DataType;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\OperatorType;

use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Simple database filter specifying column, data type, operator and value
 */
class SimpleDBFilter extends DBFilter {

  /**
   * Name of the database column being filtered on.
   *
   * @var string
   */
  protected string $column;

  /**
   * Data type of the column (string/int/bool/etc).
   *
   * @var DataType
   */
  protected DataType $dataType;

  /**
   * Comparison operator, e.g. =, !=, >, >=, <, <=, LIKE, IN.
   *
   * @var OperatorType
   */
  protected OperatorType $operator;

  /**
   * Value being compared against.
   *
   * May be scalar or array (for IN operator).
   *
   * @var mixed
   */
  protected mixed $value;

  public function __construct($column, $dataType, $operator, $value) {
    $this->column = $column;
    $this->dataType = $dataType;
    $this->operator = $operator;
    $this->value = $value;

    return parent::__construct(FilterType::SIMPLE);
  }

  public function build(): string {
    $sqlComponents = [StringUtil::encloseDatabaseIdentifier($this->column), $this->operator->value];

    if ($this->operator == OperatorType::IN) {
      $values = [];
      foreach ($this->value as $val) {
        if ($this->dataType == DataType::STRING) {
          $values[] = addslashes($val);
        }
        else {
          $values[] = $val;
        }
      }

      $sqlComponents[] = CharType::BRACKET_START . implode(", ", $values) . CharType::BRACKET_END;
    }
    else {
      if ($this->dataType == DataType::STRING) {
        $sqlComponents[] = StringUtil::encloseStringDatabaseValue(($this->value));
      }
      else {
        $sqlComponents[] = $this->value;
      }
    }

    return implode(" ", $sqlComponents);
  }


  public function stringify(){
    return print_r(
      [
        "type" => $this->type,
        "column" => $this->column,
        "dataType" => $this->dataType->value,
        "operator" => $this->operator->value,
        "value" => $this->value
      ],
      true
    );
  }
}