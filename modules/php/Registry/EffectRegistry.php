<?php
namespace Bga\Games\tycoonindianew\Registry;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\Gain;
use Bga\Games\tycoonindianew\Effect\Loss;

use Bga\Games\tycoonindianew\Type\EffectType;

class EffectRegistry extends Registry {
  
  /**
   * Add given filter to the registry
   * @param string $key
   * @param Entry $entry
   * @throws \InvalidArgumentException
   * @return void
   */
  public function add(string $key, Entry $entry) {
      if (!$entry instanceof Effect) {
          throw new \InvalidArgumentException("EffectRegistry only accepts Effect entries");
      }

      parent::add($key, $entry);
  }

  /**
   * Create new effect entry in the effect registry
   * @param array $args
   * @return Gain|Loss
   */
  public function create(array $args): Effect {
    if (array_key_exists("type", $args) && $args["type"] == EffectType::GAIN) {
      return new Gain($args["fungibleType"], (int) $args["amount"], $args["condition"], $args["spec"], (int) $args["multiplier"], $args["roundDown"]);
    }
    else {
      return new Loss($args["fungibleType"], (int) $args["amount"], $args["condition"], $args["spec"], (int) $args["multiplier"], $args["roundDown"]);
    }
  }
}