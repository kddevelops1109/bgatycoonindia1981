<?php
namespace Bga\Games\tycoonindianew\Industry\FirstAge;

use Bga\Games\tycoonindianew\Effect\Effect;

use Bga\Games\tycoonindianew\Model\Card\Industry\IndustryCard;

use Bga\Games\tycoonindianew\Type\CardAge;
use Bga\Games\tycoonindianew\Type\FungibleType as FT;
use Bga\Games\tycoonindianew\Type\Sector;

/**
 * Name: Hydro Power
 * Age: Age I
 * Revenue: 25 crores
 * Asset value: 50 crores
 * Influence: 6
 * Production: 2 Power
 * Resources: 1 Agro, 1 Transport
 */
class HydroPower extends IndustryCard {

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
    return parent::getEffect(FT::INFLUENCE, 6);
  }

  /**
   * Sector production given by this industry card
   * @return Effect
   */
  public static function production(): Effect {
    return parent::getEffect(FT::POWER, 2);
  }

  /** Constants - Misc */
  const NAME = "Hydro Power";
  const NBR = 1;
  const AGE = CardAge::AGE_I;
  const RESOURCE_SECTORS = [Sector::AGRO, Sector::TRANSPORT];
}
