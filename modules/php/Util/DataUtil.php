<?php
namespace Bga\Games\tycoonindianew\Util;

use BackedEnum;
use UnitEnum;

use Bga\Games\tycoonindianew\Type\DataType as DT;

class DataUtil {
  
  /**
   * Get the value parsed from given val and data type
   * @param mixed $val
   * @param mixed $type
   */
  public static function getValue($val, $type) {
    $value = null;

    if ($type == DT::INT) {
      $value = intval($val);
    }
    elseif ($type == DT::BOOL) {
      $value = boolval($val);
    }
    elseif ($type == DT::OBJ) {
      $value = json_decode(strval($val), true);
    }
    elseif ($type == DT::PLAYER_COUNTER || $type == DT::TABLE_COUNTER) {
      $value = $val;
    }
    elseif ($type == DT::STRING && $val instanceof BackedEnum) {
      $value = strval($val->value);
    }
    elseif ($type == DT::STRING && $val instanceof UnitEnum) {
      $value = strval($val->name);
    }
    else {
      $value = strval($val);
    }

    return $value;
  }
}