<?php
namespace Bga\Games\tycoonindianew\Token\Global\EndgameSectorFavor;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;

use Bga\Games\tycoonindianew\Model\DeckItem\Token\Global\EndgameSectorFavorToken;

use Bga\Games\tycoonindianew\Multiplier\DynamicMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Power endgame sector favor token
 */
class PowerEndgameSectorFavorToken extends EndgameSectorFavorToken {

  /**
   * Endgame sector favor effect given by this token
   * @return Effect
   */
  public static function endgameSectorFavor(): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => FungibleType::FAVOR,
      "amount" => 1,
      "multiplier" => new DynamicMultiplier([IndustrialistManager::class, "getPlayerPowerSectorProduction"]),
      "condition" => null,
      "spec" => null,
      "trigger" => null,
      "next" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /** Constants - Misc */
  const NAME = Sector::POWER->value;
  const NBR = 1;
  const SECTOR = Sector::POWER;
}