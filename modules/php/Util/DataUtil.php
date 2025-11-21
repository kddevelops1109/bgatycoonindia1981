<?php
namespace Bga\Games\tycoonindianew\Util;

class DataUtil {
  const DATA_TYPE_STRING = ["name" => "string", "abbreviation" => "%s"];
  const DATA_TYPE_INT = ["name" => "int", "abbreviation" => "%d"];
  const DATA_TYPE_BOOL = ["name" => "bool", "abbreviation" => "%d"];
  const DATA_TYPE_OBJ = ["name" => "obj", "abbreviation" => "%s"];

  /**
   * Get the value parsed from given val and data type
   * @param mixed $val
   * @param mixed $type
   */
  public static function getValue($val, $type) {
    $value = null;

    if ($type == self::DATA_TYPE_INT["name"]) {
      $value = intval($val);
    }
    elseif ($type == self::DATA_TYPE_BOOL["name"]) {
      $value = boolval($val);
    }
    elseif ($type == self::DATA_TYPE_OBJ["name"]) {
      $value = json_decode(strval($val), true);
    }
    else {
      $value = strval($val);
    }

    return $value;
  }
}