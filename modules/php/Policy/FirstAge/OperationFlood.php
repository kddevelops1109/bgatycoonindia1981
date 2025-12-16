<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\IndustrialPolicyCard;

/**
 * Name: a
 * Description:
 *  Operation Flood was a dairy development program launched in India in 1970 by the National Dairy Development Board (NDDB) with the aim of increasing milk production and providing a regular source of income to dairy farmers. It was led by Dr. Verghese Kurien.
 * Type: Industrial Policy
 * Politics Bonus: 2 Promoters in Hand
 * Endgame Influence: 2 Influence per Policy owned
 * Endgame Favor: 2 Favor
 */
class OperationFlood extends IndustrialPolicyCard {

  /**
   * Obtain endgame influence multiplier for this industrial policy card
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_POLICIES_GAINED));
  }

  /**
   * Constants - Misc
   */
  const NAME = "Operation Flood";
  const NBR = 1;
  const DESCRIPTION = "Operation Flood was a dairy development program launched in India in 1970 by the National Dairy Development Board (NDDB) with the aim of increasing milk production and providing a regular source of income to dairy farmers. It was led by Dr. Verghese Kurien.";
}