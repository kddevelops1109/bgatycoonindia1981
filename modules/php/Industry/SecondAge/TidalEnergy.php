<?php
namespace Bga\Games\tycoonindianew\Industry\SecondAge;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Tidal Energy
 * Age: Age II
 * Revenue: 15 crores
 * Asset value: 30 crores
 * Influence: 9
 * Production: 1 Power
 * Resources: Minerals
 */
class TidalEnergy extends IndustryCard {

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  public static function revenue(): Effect {
    return parent::getEffect(FT::MONEY, 15);
  }

  /**
   * Asset value of this industry card
   * @return Effect
   */
  public static function assetValue(): Effect {
    return parent::getEffect(FT::ASSET_VALUE, 30);
  }

  /**
   * Influence given by this industry card
   * @return Effect
   */
  public static function influence(): Effect {
    return parent::getEffect(FT::INFLUENCE, 9);
  }

  /**
   * Sector production given by this industry card
   * @return Effect
   */
  public static function production(): Effect {
    return parent::getEffect(FT::POWER, 1);
  }

  /** Constants - Misc */
  const NAME = "Tidal Energy";
  const NBR = 1;
  const AGE = CardAge::AGE_II;
  const RESOURCE_SECTORS = [Sector::MINERALS];
}
