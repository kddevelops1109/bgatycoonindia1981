<?php
namespace Bga\Games\tycoonindianew\Region;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Multiplier\DynamicMultiplier;
use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;
use Bga\Games\tycoonindianew\Type\RegionName;

class West extends Region {

  /**
   * Get instance of North region
   * @return static
   */
  public static function get(): static {
    return parent::instance(RegionName::WEST);
  }

  /**
   * Build plant bonus for this region
   * @return Effect
   */
  protected function initBuildPlantBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::MONEY,
      "multiplier" => StaticMultiplier::instance(1),
      "amount" => 5,
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Tycoon activation bonus for this region for given player
   * @return Effect
   */
  protected function initTycoonActivationBonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::MONEY,
      "multiplier" => new DynamicMultiplier([IndustrialistManager::class, "countBuiltPlantsInRegion"]),
      "amount" => 5,
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }
}