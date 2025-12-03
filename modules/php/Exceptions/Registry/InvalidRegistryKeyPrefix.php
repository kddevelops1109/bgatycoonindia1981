<?php
namespace Bga\Games\tycoonindianew\Exceptions\Registry;

use Bga\Games\tycoonindianew\Exceptions\RegistryException;

class InvalidRegistryKeyPrefixException extends RegistryException {

  public static function forKey(string $key) {
    return new self("The key '" . $key . "' has an invalid prefix.");
  }
}