<?php
namespace Bga\Games\tycoonindianew\Type;

enum OperatorType: string {
  case EQUALS = "=";
  case NOT_EQUALS = "!=";
  case GREATER_THAN = ">";
  case GREATER_THAN_EQUAKS = ">=";
  case LESSER_THAN = "<";
  case LESSER_THAN_EQUAKS = "<=";
  case LIKE = "LIKE";
  case IN = "IN";
}