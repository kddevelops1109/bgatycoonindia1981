<?php
namespace Bga\Games\tycoonindianew\Industry\FirstAge;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;
use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Thermal Power
 * Age: Age I
 * Revenue: 20 crores
 * Asset value: 40 crores
 * Influence: 7
 * Production: 2 Power
 * Resources: Fuel, Transport
 */
class ThermalPower extends IndustryCard {

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  public static function revenue(): Effect {
    return parent::getEffect(FT::MONEY, 20);
  }

  /**
   * Asset value of this industry card
   * @return Effect
   */
  public static function assetValue(): Effect {
    return parent::getEffect(FT::ASSET_VALUE, 40);
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
  const NAME = "Thermal Power";
  const AGE = CardAge::AGE_I;
  const RESOURCE_SECTORS = [Sector::FUEL, Sector::TRANSPORT];
}
