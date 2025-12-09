<?php
namespace Bga\Games\tycoonindianew\Industry\SecondAge;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Wind Energy
 * Age: Age II
 * Revenue: 25 crores
 * Asset value: 50 crores
 * Influence: 7
 * Production: 2 Power
 * Resources: Minerals, Transport
 */
class WindEnergy extends IndustryCard {

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  public static function revenue(): Effect {
    return parent::getEffect(FT::MONEY, 25);
  }

  /**
   * Asset value of this industry card
   * @return Effect
   */
  public static function assetValue(): Effect {
    return parent::getEffect(FT::ASSET_VALUE, 50);
  }

  /**
   * Influence given by this industry card
   * @return Effect
   */
  public static function influence(): Effect {
    return parent::getEffect(FT::INFLUENCE, 7);
  }

  /**
   * Sector production given by this industry card
   * @return Effect
   */
  public static function production(): Effect {
    return parent::getEffect(FT::POWER, 2);
  }

  /** Constants - Misc */
  const NAME = "Wind Energy";
  const AGE = CardAge::AGE_II;
  const RESOURCE_SECTORS = [Sector::MINERALS, Sector::TRANSPORT];
}
