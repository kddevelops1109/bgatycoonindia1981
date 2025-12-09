<?php
namespace Bga\Games\tycoonindianew\Industry\FirstAge;

use Bga\Games\tycoonindianew\Effect\Effect;
use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Coal Mines
 * Age: Age I
 * Revenue: 30 crores
 * Asset value: 60 crores
 * Influence: 5
 * Production: 2 Fuel
 * Resources: 1 Minerals, 1 Transport
 */
class CoalMines extends IndustryCard {

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  public static function revenue(): Effect {
    return parent::getEffect(FT::MONEY, 30);
  }

  /**
   * Asset value of this industry card
   * @return Effect
   */
  public static function assetValue(): Effect {
    return parent::getEffect(FT::ASSET_VALUE, 60);
  }

  /**
   * Influence given by this industry card
   * @return Effect
   */
  public static function influence(): Effect {
    return parent::getEffect(FT::INFLUENCE, 5);
  }

  /**
   * Sector production given by this industry card
   * @return Effect
   */
  public static function production(): Effect {
    return parent::getEffect(FT::FUEL, 2);
  }

  /** Constants - Misc */
  const NAME = "Coal Mines";
  const AGE = CardAge::AGE_I;
  const RESOURCE_SECTORS = [Sector::MINERALS, Sector::TRANSPORT];
}
