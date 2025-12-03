<?php
namespace Bga\Games\tycoonindianew\Condition;

use Bga\Games\tycoonindianew\Registry\RegistryKeyPrefix;
use Bga\Games\tycoonindianew\Type\ConditionStatus;

class NullCondition extends Condition {

  private static ?NullCondition $instance = null;

  private function __construct() {
    parent::__construct(RegistryKeyPrefix::NULL_CONDITION->value, null, null);
    $this->status = ConditionStatus::PASS;
  }

  public static function get(): NullCondition {
    if (is_null(self::$instance)) {
      self::$instance = new NullCondition();
    }

    return self::$instance;
  }

  /**
   * Always passes on evaluation
   * @return ConditionStatus
   */
  public function evaluate(): ConditionStatus {
    return ConditionStatus::PASS;
  }
}