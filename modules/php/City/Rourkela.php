<?php
namespace Bga\Games\tycoonindianew\City;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\TokenSpace\City\City;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Region\East;
use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\CityName;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;
use Bga\Games\tycoonindianew\Type\RegionName;

use Bga\Games\tycoonindianew\Util\StringUtil;

class Rourkela extends City {

  public static function getOrCreate(array $args): static {
    return parent::instance($args, CityName::ROURKELA, East::get());
  }

  public static function bonus(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::FUEL,
      "amount" => 1,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  public static function generateSpaceId(?array $args): string {
    return strtolower(StringUtil::strToKebab(CityName::ROURKELA->value));
  }

  /**
   * City before this city on the map
   * @return City
   */
  public function before(): City {
    return Jamshedpur::get();
  }

  /**
   * City after this city on the map
   * @return City
   */
  public function after(): City {
    return Hirakud::get();
  }

  /** Constants - Misc */
  const NAME = CityName::ROURKELA;
  const REGION = RegionName::EAST;
}