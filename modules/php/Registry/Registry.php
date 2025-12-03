<?php
namespace Bga\Games\tycoonindianew\Registry;

use Bga\Games\tycoonindianew\Exceptions\Registry\DuplicateEntryException;
use Bga\Games\tycoonindianew\Exceptions\Registry\EntryNotFoundException;
use Bga\Games\tycoonindianew\Exceptions\Registry\InvalidRegistryKeyPrefixException;

/**
 * Registry of various entries
 */
abstract class Registry {

  /**
   * Entries array for this registry
   * @var array<string, Entry>
   */
  protected array $entries = [];

  /**
   * Static array of instances
   * @var array<string, static>
   */
  private static array $instances = [];

  private function __construct() {
    $this->entries = [];
  }

  final public static function instance(): static {
    $class = static::class;

    if (!isset(self::$instances[$class])) {
        self::$instances[$class] = new static();
    }

    return self::$instances[$class];
  }

  /**
   * Creates a new entry to be added to the registry
   * @param array $args
   * @return Entry
   */
  abstract protected function create(array $args): Entry;

  public function getOrCreate(string $key, array $args): Entry {
    if ($this->contains($key)) {
      return $this->get($key);
    }

    $entry = $this->create($args);
    $this->add($key, $entry);

    return $entry;
  }

  /**
   * Does this registry have given key in it, irrespective of whether the entry is null or non-null
   * @param string $key
   * @return bool
   */
  public function contains(string $key) {
    return array_key_exists($key,$this->entries);
  }

  /**
   * Add new entry to registry with given key
   * @param string $key
   * @param Entry $entry
   * @return void
   */
  public function add(string $key, Entry $entry) {
    if ($this->contains($key)) {
      DuplicateEntryException::forKey($key);
    }
    elseif (!RegistryKeyPrefix::isValid($key)) {
      InvalidRegistryKeyPrefixException::forKey($key);
    }
    else {
      $this->entries[$key] = $entry;
    }
  }

  /**
   * Get registry entry for given key
   * @param string $key
   * @return Entry
   */
  public function get(string $key) {
    if (!$this->contains($key)) {
      EntryNotFoundException::forKey($key);
    }
    
    return $this->entries[$key];
  }

  /**
   * Remove registry entry for given key
   * @param string $key
   * @return void
   */
  public function remove(string $key) {
    if (!$this->contains($key)) {
      EntryNotFoundException::forKey($key);
    }
    else {
      unset($this->entries[$key]);
    }
  }
}