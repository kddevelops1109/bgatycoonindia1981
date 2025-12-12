<?php
namespace Bga\Games\tycoonindianew\Type;

enum OperatorType: string {
  case EQUALS = "=";
  case NOT_EQUALS = "!=";
  case GREATER_THAN = ">";
  case GREATER_THAN_EQUALS = ">=";
  case LESSER_THAN = "<";
  case LESSER_THAN_EQUALS = "<=";
  case LIKE = "LIKE";
  case IN = "IN";
}