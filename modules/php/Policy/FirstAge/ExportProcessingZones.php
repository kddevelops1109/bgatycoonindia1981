<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\IndustrialPolicyCard;

/**
 * Name: Export Processing Zones
 * Description:
 *  Export Processing Zones (EPZs) were established in India in the 1960s as special economic zones with the aim of promoting exports, attracting foreign investment, and creating employment. The first EPZ was set up in Kandla, Gujarat in 1965.
 * Type: Industrial Policy
 * Politics Bonus: 2 Promoters in Hand
 * Endgame Influence: 1 Influence per built plant
 * Endgame Favor: 2 Favor
 */
class ExportProcessingZones extends IndustrialPolicyCard {

  /**
   * Obtain endgame influence multiplier for this industrial policy card
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_BUILT_PLANTS));
  }

  /**
   * Constants - Misc
   */
  const NAME = "Export Processing Zones";
  const NBR = 1;
  const DESCRIPTION = "Export Processing Zones (EPZs) were established in India in the 1960s as special economic zones with the aim of promoting exports, attracting foreign investment, and creating employment. The first EPZ was set up in Kandla, Gujarat in 1965.";
}