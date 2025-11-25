<?php
namespace Bga\Games\tycoonindianew\Util;

use Bga\GameFramework\Components\Counters\PlayerCounter;
use Bga\GameFramework\Components\Counters\TableCounter;

class DataUtil {
  const DATA_TYPE_STRING = "string";
  const DATA_TYPE_INT = "int";
  const DATA_TYPE_BOOL = "bool";
  const DATA_TYPE_OBJ = "obj";
  const DATA_TYPE_PLAYER_COUNTER = "playerCounter";
  const DATA_TYPE_TABLE_COUNTER = "tableCounter";

  /**
   * Get the value parsed from given val and data type
   * @param mixed $val
   * @param mixed $type
   */
  public static function getValue($val, $type) {
    $value = null;

    if ($type == self::DATA_TYPE_INT) {
      $value = intval($val);
    }
    elseif ($type == self::DATA_TYPE_BOOL) {
      $value = boolval($val);
    }
    elseif ($type == self::DATA_TYPE_OBJ) {
      $value = json_decode(strval($val), true);
    }
    elseif ($type == self::DATA_TYPE_PLAYER_COUNTER || $type == self::DATA_TYPE_TABLE_COUNTER) {
      $value = $val;
    }
    else {
      $value = strval($val);
    }

    return $value;
  }
}