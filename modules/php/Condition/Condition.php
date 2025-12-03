<?php
namespace Bga\Games\tycoonindianew\Condition;

use Bga\Games\tycoonindianew\Manager\DBManager;
use Bga\Games\tycoonindianew\Query\SelectDBQuery;
use Bga\Games\tycoonindianew\Registry\Entry;
use Bga\Games\tycoonindianew\Type\ConditionStatus;

/**
 * Represents a condition that can be evaluated to trigger a game flow. Contains a select query that can be executed.
 * @property string $key ID of the condition
 * @property SelectDBQuery $query Select query to execute in order to evaluate the same
 * @property mixed $expectedResult Expected result of this condition
 * @property mixed $result Actual result of this condition
 * @property ConditionStatus $status Indicates if this condition passed or failed
 */
#[\AllowDynamicProperties]
class Condition implements Entry {

  public function __construct(
    public readonly string $key,
    public readonly ?SelectDBQuery $query,
    public mixed $expectedResult
  ) {}

  /**
   * Evaluates the query and if result matches the expected result, this passes
   * @return ConditionStatus
   */
  public function evaluate(): ConditionStatus {
    $this->status = ConditionStatus::FAIL;
    if (!is_null($this->query)) {
      $this->result = DBManager::execute($this->query);
      if ($this->result === $this->expectedResult) {
        $this->status = ConditionStatus::PASS;
      }
    }

    return $this->status;
  }
}