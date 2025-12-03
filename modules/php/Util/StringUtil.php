<?php
namespace Bga\Games\tycoonindianew\Util;

use Bga\Games\tycoonindianew\Type\CharType;

class StringUtil {
  public static function encloseSpaces($str) {
    return " " . $str . " ";
  }

  public static function strCounterize($str) {
    return strtolower(str_replace("_", "-", $str));
  }

  public static function uuid(): string {
    $data = random_bytes(16);
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  /**
   * Enclose the given database identifier within backtick character
   * @param string $identifier
   * @return string
   */
  public static function encloseDatabaseIdentifier(string $identifier) {
    return CharType::BACKTICK->value . $identifier . CharType::BACKTICK->value;
  }

  /**
   * Enclose the given database value within single quotes
   * @param string $value
   * @return string
   */
  public static function encloseStringDatabaseValue(string $value) {
    return CharType::SINGLE_QUOTE->value . $value . CharType::SINGLE_QUOTE->value;
  }

  /**
   * Returns snake case of given string
   * @param string $str
   * @return string
   */
  public static function strSnakeCase(string $str): string {
    return str_replace(" ", "_", strtolower($str));
  }

  /**
   * Convert given class name to kebab string
   * @param class-string $class
   * @return string
   */
  public static function classToKebab(string $class): string {
    $short = substr(strrchr($class, '\\'), 1) ?: $class;
    return self::strToKebab($short);
  }

  /**
   * Convert given string to kebab string
   * @param string $str
   * @return string
   */
  public static function strToKebab(string $str): string {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $str));
  }
}