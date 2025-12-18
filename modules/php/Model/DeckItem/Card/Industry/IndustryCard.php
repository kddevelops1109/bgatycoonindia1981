<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Industry;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Effect\EffectKeyGenerator;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Card;

use Bga\Games\tycoonindianew\Multiplier\StaticMultiplier;

use Bga\Games\tycoonindianew\Registry\EffectRegistry;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\EffectType;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Represents an industry card
 * @property CardAge $age Age of the industry
 * @property Effect $revenue Revenue given by this industry during Revenue phase
 * @property Effect $assetValue End-game asset value given by this industry
 * @property Effect $influence Influence given by this industry on building a plant for it
 * @property Effect $production Industrial sector production gained on building a plant for this industry
 * @property array<Sector> $resourceSectors Sectors that represent the resource costs of building a plant for this industry
 */
abstract class IndustryCard extends Card {

  public static function staticFieldArgs(): array {
    return [
      ...parent::staticFieldArgs(),
      [
        self::FIELD_AGE => static::AGE,
        self::FIELD_REVENUE => static::revenue(),
        self::FIELD_ASSET_VALUE => static::assetValue(),
        self::FIELD_INFLUENCE => static::influence(),
        self::FIELD_PRODUCTION => static::production(),
        self::FIELD_RESOURCE_SECTORS => static::RESOURCE_SECTORS
      ]
    ];
  }

  /**
   * Creates and gets new effect of given fungible type for this industry card
   * @param FT $fungibleType
   * @param int $amount
   * @return Effect
   */
  public static function getEffect(FT $fungibleType, int $amount): Effect {
    $args = [
      "type" => EffectType::GAIN,
      "fungibleType" => $fungibleType,
      "amount" => $amount,
      "multiplier" => StaticMultiplier::instance(1),
      "condition" => null,
      "spec" => null,
      "next" => null,
      "trigger" => null,
      "roundDown" => false
    ];

    return EffectRegistry::instance()->getOrCreate(EffectKeyGenerator::generate($args), $args);
  }

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  abstract public static function revenue(): Effect;

  /**
   * Asset value of this industry card
   * @return Effect
   */
  abstract public static function assetValue(): Effect;

  /**
   * Influence given by this industry card
   * @return Effect
   */
  abstract public static function influence(): Effect;

  /**
   * Sector production given by this industry card
   * @return Effect
   */
  abstract public static function production(): Effect;

  /**
   * Industry cards can be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return true;
  }

  /**
   * Industry cards cannot be lost once gained
   * @return bool
   */
  public function canBeLost(): bool {
    return false;
  }

  /**
   * Constants - Filepaths and Classpaths
   */
  const FILEPATH_AGE_I = "/../../../Industry/FirstAge/list.inc.php";
  const FILEPATH_AGE_II = "/../../../Industry/SecondAge/list.inc.php";

  const CLASSPATH_AGE_I = "\Bga\Games\\tycoonindianew\Industry\FirstAge";
  const CLASSPATH_AGE_II = "\Bga\Games\\tycoonindianew\Industry\SecondAge";

   /** Constants - Field names */
  const FIELD_AGE = "age";
  const FIELD_REVENUE = "revenue";
  const FIELD_ASSET_VALUE = "assetValue";
  const FIELD_INFLUENCE = "influence";
  const FIELD_PRODUCTION = "production";
  const FIELD_RESOURCE_SECTORS = "resourceSectors";

  /** Constants - Misc */
  const NBR = 1;
}