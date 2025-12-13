<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\Policy\IndustrialPolicyCard;

/**
 * Name: Food Corporation of India
 * Description:
 *  Established in 1965. The primary objective of the FCI is to ensure the availability of food grains at reasonable prices for the public distribution system and to maintain a sufficient buffer stock of food grains for the national food security.
 * Type: Industrial Policy
 * Politics Bonus: 2 Promoters in Hand
 * Endgame Influence: 3 Influence per Agro and Transport industry owned
 * Endgame Favor: 2 Favor
 */
class FoodCorporationOfIndia extends IndustrialPolicyCard {

  /**
   * Obtain endgame influence multiplier for this industrial policy card
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_AGRO_INDUSTRIES)) +
           floatval(IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_TRANSPORT_INDUSTRIES));
  }

  /**
   * Constants - Misc
   */
  const NAME = "Food Corporation of India";
  const NBR = 1;
  const DESCRIPTION = "Established in 1965. The primary objective of the FCI is to ensure the availability of food grains at reasonable prices for the public distribution system and to maintain a sufficient buffer stock of food grains for the national food security.";
}