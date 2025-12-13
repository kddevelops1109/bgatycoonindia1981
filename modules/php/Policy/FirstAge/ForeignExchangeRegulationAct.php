<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\Policy\IndustrialPolicyCard;

/**
 * Name: Foreign Exchange Regulation Act
 * Description:
 *  The Foreign Exchange Regulation Act (FERA) 1973 is an Indian law that was enacted to regulate foreign exchange transactions and foreign payments in the country. Under FERA, all foreign exchange transactions required the prior approval of the RBI.
 * Type: Industrial Policy
 * Politics Bonus: 2 Promoters in Hand
 * Endgame Influence: 3 Influence per Finance and Minerals industry owned
 * Endgame Favor: 2 Favor
 */
class ForeignExchangeRegulationAct extends IndustrialPolicyCard {

  /**
   * Obtain endgame influence multiplier for this industrial policy card
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameInfluenceMultiplier(int $playerId): float {
    return floatval(IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_FINANCE_INDUSTRIES)) +
           floatval(IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_MINERALS_INDUSTRIES));
  }

  /**
   * Constants - Misc
   */
  const NAME = "Foreign Exchange Regulation Act";
  const NBR = 1;
  const DESCRIPTION = "The Foreign Exchange Regulation Act (FERA) 1973 is an Indian law that was enacted to regulate foreign exchange transactions and foreign payments in the country. Under FERA, all foreign exchange transactions required the prior approval of the RBI.";
}