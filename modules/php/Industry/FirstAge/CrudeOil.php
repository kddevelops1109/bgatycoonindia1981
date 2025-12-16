<?php
namespace Bga\Games\tycoonindianew\Industry\FirstAge;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Industry\IndustryCard;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Crude Oil
 * Age: Age I
 * Revenue: 40 crores
 * Asset value: 80 crores
 * Influence: 3
 * Production: 2 Fuel
 * Resources: Minerals, Transport
 */
class CrudeOil extends IndustryCard {

  /**
   * Revenue given by this industry card
   * @return Effect
   */
  public static function revenue(): Effect {
    return parent::getEffect(FT::MONEY, 40);
  }

  /**
   * Asset value of this industry card
   * @return Effect
   */
  public static function assetValue(): Effect {
    return parent::getEffect(FT::ASSET_VALUE, 80);
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
    return parent::getEffect(FT::FUEL, 2);
  }

  /** Constants - Misc */
  const NAME = "Crude Oil";
  const NBR = 1;
  const AGE = CardAge::AGE_I;
  const RESOURCE_SECTORS = [Sector::MINERALS, Sector::TRANSPORT];
}
