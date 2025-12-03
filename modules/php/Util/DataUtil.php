<?php
namespace Bga\Games\tycoonindianew\Util;

use BackedEnum;
use UnitEnum;

use Bga\Games\tycoonindianew\Type\DataType;

class DataUtil {
  
  /**
   * Get the value parsed from given val and data type
   * @param mixed $val
   * @param mixed $type
   */
  public static function getValue($val, $type) {
    $value = null;

    if ($type == DataType::INT) {
      $value = intval($val);
    }
    elseif ($type == DataType::BOOL) {
      $value = boolval($val);
    }
    elseif ($type == DataType::OBJ) {
      $value = json_decode(strval($val), true);
    }
    elseif ($type == DataType::PLAYER_COUNTER || $type == DataType::TABLE_COUNTER) {
      $value = $val;
    }
    elseif ($type == DataType::STRING && $val instanceof BackedEnum) {
      $value = strval($val->value);
    }
    elseif ($type == DataType::STRING && $val instanceof UnitEnum) {
      $value = strval($val->name);
    }
    else {
      $value = strval($val);
    }

    return $value;
  }
}