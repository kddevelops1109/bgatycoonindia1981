<?php
namespace Bga\Games\tycoonindianew\Registry;

use Bga\Games\tycoonindianew\Condition\NullCondition;
use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\Gain;
use Bga\Games\tycoonindianew\Effect\Loss;
use Bga\Games\tycoonindianew\Spec\NullSpec;
use Bga\Games\tycoonindianew\Type\EffectType;

class EffectRegistry extends Registry {

  /**
   * Returns the registered effect for given key, if present, else creates it using the given args and returns it
   * @return Effect
   */
  public function getOrCreate(string $key, array $args): Effect {
      /** @var Effect $effect */
      $effect = parent::getOrCreate($key, $args);
      return $effect;
  }
  
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
    if (!array_key_exists("condition", $args)) {
      $args["condition"] = NullCondition::get();
    }

    if (!array_key_exists("spec", $args)) {
      $args["spec"] = NullSpec::get();
    }

    if (!array_key_exists("next", $args)) {
      $args["next"] = null;
    }

    if (!array_key_exists("trigger", $args)) {
      $args["trigger"] = null;
    }

    if (array_key_exists("type", $args) && $args["type"] == EffectType::GAIN) {
      return new Gain($args["fungibleType"], (int) $args["amount"], $args["multiplier"], $args["condition"], $args["spec"], $args["next"], $args["trigger"], $args["roundDown"]);
    }
    else {
      return new Loss($args["fungibleType"], (int) $args["amount"], $args["multiplier"], $args["condition"], $args["spec"], $args["next"], $args["trigger"], $args["roundDown"]);
    }
  }
}