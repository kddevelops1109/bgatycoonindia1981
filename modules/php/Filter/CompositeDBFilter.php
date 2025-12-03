<?php
namespace Bga\Games\tycoonindianew\Filter;

use Bga\Games\tycoonindianew\Filter\DBFilter;

use Bga\Games\tycoonindianew\Type\CharType;
use Bga\Games\tycoonindianew\Type\FilterType;
use Bga\Games\tycoonindianew\Type\JoinType;

use Bga\Games\tycoonindianew\Util\StringUtil;

/**
 * Composite database filter that joins other filters, which could be simple or composite themselves
 */
class CompositeDBFilter extends DBFilter {

  /**
   * Join operator for this composite filter (AND/OR).
   *
   * @var JoinType
   */
  protected JoinType $join;

  /**
   * Array of nested DBFilter objects (simple or composite).
   *
   * @var array<DBFilter>
   */
  protected array $filters;

  public function __construct($join, $filters) {
    $this->join = $join;
    $this->filters = $filters;

    return parent::__construct(FilterType::COMPOSITE);
  }

  public function build(): string {
    $sqlComponents = [];

    $sqlFilters = [];
    foreach ($this->filters as $filter) {
      if ($filter instanceof DBFilter) {
        $sqlFilters[] = $filter->build();
      }
    }

    if ($this->join == JoinType::AND) {
      $sqlComponents[] = implode(StringUtil::encloseSpaces(JoinType::AND->name), $sqlFilters);
    }
    elseif ($this->join == JoinType::OR) {
      $sqlComponents[] = CharType::BRACKET_START;
      $sqlComponents[] = implode(StringUtil::encloseSpaces(JoinType::OR->name), $sqlFilters);
      $sqlComponents[] = CharType::BRACKET_END;
    }

    return implode("", $sqlComponents);
  }

  public function stringify(){
    return print_r(
      [
        "type" => $this->type,
        "join" => $this->join->name,
        "filters" => print_r($this->filters, true)
      ],
      true
    );
  }
}