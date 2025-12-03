<?php
namespace Bga\Games\tycoonindianew\Type;

enum CharType: string {

  case BACKTICK = "`";
  case SINGLE_QUOTE = "'";
  case BRACKET_START = '(';
  case BRACKET_END = ')';
}