<?php
namespace Bga\Games\tycoonindianew\Policy\FirstAge;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\Policy\IndustrialPolicyCard;

/**
 * Name: Nationalisation of Coal Mines
 * Description:
 *  The nationalization of coal mines in India refers to the transfer of ownership and control of coal mines from private entities to the Indian Government. This was carried out through the Coal Mines (Nationalisation) Act. 1973
 * Type: Industrial Policy
 * Politics Bonus: 2 Promoters in Hand
 * Endgame Influence: 3 Influence per Power and Fuel industry owned
 * Endgame Favor: 2 Favor
 */
class NationalisationOfCoalMines extends IndustrialPolicyCard {

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
  const NAME = "Nationalisation of Coal Mines";
  const NBR = 1;
  const DESCRIPTION = "The nationalization of coal mines in India refers to the transfer of ownership and control of coal mines from private entities to the Indian Government. This was carried out through the Coal Mines (Nationalisation) Act. 1973";
}