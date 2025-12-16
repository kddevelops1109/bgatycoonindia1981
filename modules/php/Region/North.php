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

class North extends Region {

  /**
   * Get instance of North region
   * @return static
   */
  public static function get(): static {
    return parent::instance(RegionName::NORTH);
  }

  /**
   * Build plant bonus for this region
   * @return void
   */
  protected function initBuildPlantBonus(): void {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::INFLUENCE,
      "multiplier" => StaticMultiplier::instance(1),
      "amount" => 1,
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    $this->buildPlantBonus = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Tycoon activation bonus for this region for given player
   * @return void
   */
  protected function initTycoonActivationBonus(): void {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::INFLUENCE,
      "multiplier" => new DynamicMultiplier([IndustrialistManager::class, "countBuiltPlantsInRegion"]),
      "amount" => 1,
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    $this->tycoonActivationBonus = EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }
}