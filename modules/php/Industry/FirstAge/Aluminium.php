<?php
namespace Bga\Games\tycoonindianew\Industry\FirstAge;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Aluminium
 * Age: Age II
 * Revenue: 35 crores
 * Asset value: 70 crores
 * Influence: 4
 * Production: 2 Minerals
 * Resources: 1 Fuel, 1 Transport
 */
class Aluminium extends IndustryCard {

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  public static function revenue(): Effect {
    return parent::getEffect(FT::MONEY, 35);
  }

  /**
   * Asset value of this industry card
   * @return Effect
   */
  public static function assetValue(): Effect {
    return parent::getEffect(FT::ASSET_VALUE, 70);
  }

  /**
   * Influence given by this industry card
   * @return Effect
   */
  public static function influence(): Effect {
    return parent::getEffect(FT::INFLUENCE, 4);
  }

  /**
   * Sector production given by this industry card
   * @return Effect
   */
  public static function production(): Effect {
    return parent::getEffect(FT::MINERALS, 2);
  }

  /** Constants - Misc */
  const NAME = "Aluminium";
  const AGE = CardAge::AGE_I;
  const RESOURCE_SECTORS = [Sector::FUEL, Sector::TRANSPORT];
}