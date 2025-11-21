<?php
namespace BGA\Games\tycoonindianew\DB\Filter;

abstract class DBFilter {

  /**
   * Type of filter,i.e. simple/composite
   * @var string
   */
  protected $type;

  public function __construct($type) {
    $this->type = $type;
  }

  /**
   * Builds a string representing this filter that can be plugged into a DB query
   * @return string
   */
  abstract public function build();

  abstract public function stringify();

  /**
   * Constants - Types
   */
  const TYPE_SIMPLE = "simple";
  const TYPE_COMPOSITE = "composite";
}