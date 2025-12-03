<?php
namespace Bga\Games\tycoonindianew\Exceptions\Registry;

use Bga\Games\tycoonindianew\Exceptions\RegistryException;

class DuplicateEntryException extends RegistryException {

  public static function forKey(string $key) {
    return new self("Entry with key '" . $key . "' already present in registry.");
  }
}