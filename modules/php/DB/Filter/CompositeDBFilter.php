<?php
namespace Bga\Games\tycoonindianew\DB\Filter;

use Bga\Games\tycoonindianew\DB\Filter\DBFilter;
use Bga\Games\tycoonindianew\DB\Query\DBQuery;
use Bga\Games\tycoonindianew\Util\StringUtil;

class CompositeDBFilter extends DBFilter {

  /**
   * Join for this composite filter (AND/OR)
   * @var string
   */
  protected $join;

  /**
   * Array of DB filters - simple/composite/both
   * @var array
   */
  protected $filters;

  public function __construct($join, $filters) {
    $this->join = $join;
    $this->filters = $filters;

    return parent::__construct(DBFilter::TYPE_COMPOSITE);
  }

  public function build(): string {
    $sqlComponents = [];

    $sqlFilters = [];
    foreach ($this->filters as $filter) {
      if ($filter instanceof DBFilter) {
        $sqlFilters[] = $filter->build();
      }
    }

    if ($this->join == self::JOIN_AND) {
      $sqlComponents[] = implode(StringUtil::encloseSpaces(self::JOIN_AND), $sqlFilters);
    }
    elseif ($this->join == self::JOIN_OR) {
      $sqlComponents[] = DBQuery::CHAR_BRACKET_START;
      $sqlComponents[] = implode(StringUtil::encloseSpaces(self::JOIN_OR), $sqlFilters);
      $sqlComponents[] = DBQuery::CHAR_BRACKET_END;
    }

    return implode("", $sqlComponents);
  }

  public function stringify(){
    return print_r(
      [
        "type" => $this->type,
        "join" => $this->join,
        "filters" => print_r($this->filters, true)
      ],
      true
    );
  }

  /**
   * Constants - Joins
   */
  const JOIN_AND = "AND";
  const JOIN_OR = "OR";
}