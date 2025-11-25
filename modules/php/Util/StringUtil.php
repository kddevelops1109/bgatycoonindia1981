<?php
namespace Bga\Games\tycoonindianew\Util;

class StringUtil {
  public static function encloseSpaces($str) {
    return " " . $str . " ";
  }

  public static function strCounterize($str) {
    return strtolower(str_replace("_", "-", $str));
  }
}