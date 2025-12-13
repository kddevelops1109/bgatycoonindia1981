<?php
namespace Bga\Games\tycoonindianew\Industry\SecondAge;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Copper
 * Age: Age II
 * Revenue: 45 crores
 * Asset value: 90 crores
 * Influence: 3
 * Production: 2 Minerals
 * Resources: 1 Fuel, 1 Transport
 */
class Copper extends IndustryCard {

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  public static function revenue(): Effect {
    return parent::getEffect(FT::MONEY, 45);
  }

  /**
   * Asset value of this industry card
   * @return Effect
   */
  public static function assetValue(): Effect {
    return parent::getEffect(FT::ASSET_VALUE, 90);
  }

  /**
   * Influence given by this industry card
   * @return Effect
   */
  public static function influence(): Effect {
    return parent::getEffect(FT::INFLUENCE, 3);
  }

  /**
   * Sector production given by this industry card
   * @return Effect
   */
  public static function production(): Effect {
    return parent::getEffect(FT::MINERALS, 2);
  }

  /** Constants - Misc */
  const NAME = "Copper";
  const NBR = 1;
  const AGE = CardAge::AGE_II;
  const RESOURCE_SECTORS = [Sector::FUEL, Sector::TRANSPORT];
}
