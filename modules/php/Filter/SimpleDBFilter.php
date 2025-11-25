<?php
namespace Bga\Games\tycoonindianew\Filter;

use Bga\Games\tycoonindianew\Query\DBQuery;

use Bga\Games\tycoonindianew\Util\DataUtil;

class SimpleDBFilter extends DBFilter {

  /**
   * Name of column being filtered on
   * @var string
   */
  protected string $column;

  /**
   * Data type of the column being filtered on
   * @var string
   */
  protected string $dataType;

  /**
   * Represents the comparison operator, i.e. =/!=/>/>=/</<=/LIKE/IN
   * @var string
   */
  protected string $operator;

  /**
   * Value of the filter
   * @var mixed
   */
  protected mixed $value;

  public function __construct($column, $dataType, $operator, $value) {
    $this->column = $column;
    $this->dataType = $dataType;
    $this->operator = $operator;
    $this->value = $value;

    return parent::__construct(DBFilter::TYPE_SIMPLE);
  }

  public function build(): string {
    $sqlComponents = [DBQuery::encloseIdentifier($this->column), $this->operator];

    if ($this->operator == self::OPERATOR_IN) {
      $values = [];
      foreach ($this->value as $val) {
        if ($this->dataType == DataUtil::DATA_TYPE_STRING) {
          $values[] = addslashes($val);
        }
        else {
          $values[] = $val;
        }
      }

      $sqlComponents[] = DBQuery::CHAR_BRACKET_START . implode(", ", $values) . DBQuery::CHAR_BRACKET_END;
    }
    else {
      if ($this->dataType == DataUtil::DATA_TYPE_STRING) {
        $sqlComponents[] = DBQuery::encloseStringValue(($this->value));
      }
      else {
        $sqlComponents[] = $this->value;
      }
    }

    $sql = implode(" ", $sqlComponents);

    return $sql;
  }


  public function stringify(){
    return print_r(
      [
        "type" => $this->type,
        "column" => $this->column,
        "dataType" => $this->dataType,
        "operator" => $this->operator,
        "value" => $this->value
      ],
      true
    );
  }

  /**
   * Constants - Comparison operators
   */
  const OPERATOR_EQUALS = "=";
  const OPERATOR_NOT_EQUALS = "!=";
  const OPERATOR_GREATER_THAN = ">";
  const OPERATOR_GREATER_THAN_EQUAKS = ">=";
  const OPERATOR_LESSER_THAN = "<";
  const OPERATOR_LESSER_THAN_EQUAKS = "<=";
  const OPERATOR_LIKE = "LIKE";
  const OPERATOR_IN = "IN";
}