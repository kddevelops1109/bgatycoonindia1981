<?php
namespace Bga\Games\tycoonindianew\Exceptions\Registry;

use Bga\Games\tycoonindianew\Exceptions\RegistryException;

class EntryNotFoundException extends RegistryException {

  public static function forKey(string $key) {
    return new self("Entry with key '" . $key . "' not found in registry.");
  }
}