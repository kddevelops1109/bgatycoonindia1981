<?php
namespace Bga\Games\tycoonindianew\Type;

/**
 * Type of Spec
 */
enum SpecType: string {
  case CARD = "Card";
  case TOKEN = "Token";
  case ACTION = "Action";
  case NULL = "Null";
}