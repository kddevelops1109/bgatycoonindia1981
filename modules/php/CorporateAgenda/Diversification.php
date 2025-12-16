<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\CorporateAgendaCard;

class Diversification extends CorporateAgendaCard {

  /**
   * Obtain endgame favor for given player based on their endgame money in hand
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameFavorMultiplier(int $playerId): float {
    $multiplier = 0.0;

    // If the player is the owner of the corporate agenda, then evaluate and return specific multiplier
    if (!is_null($playerId) && $playerId === $this->cardLocationArg) {
      $sectors = [
        IndustrialistManager::COUNTER_INDUSTRIALIST_FINANCE,
        IndustrialistManager::COUNTER_INDUSTRIALIST_MINERALS,
        IndustrialistManager::COUNTER_INDUSTRIALIST_FUEL,
        IndustrialistManager::COUNTER_INDUSTRIALIST_AGRO,
        IndustrialistManager::COUNTER_INDUSTRIALIST_POWER,
        IndustrialistManager::COUNTER_INDUSTRIALIST_TRANSPORT
      ];

      $numSectors = 0;
      
      foreach ($sectors as $sector) {
        $sectorLevel = IndustrialistManager::getPlayerCounterValue($playerId, $sector);
        if ($sectorLevel >= 2) {
          $numSectors++;
        }
      }

      foreach ($sectors as $sector) {
        $sectorLevel = IndustrialistManager::getPlayerCounterValue($playerId, $sector);
        if ($sectorLevel >= 2) {
          $numSectors++;
        }
      }

      foreach (self::FAVOR_REFERENCE as $threshold => $favor) {
        if ($numSectors >= $threshold) {
          $multiplier = $favor;
        }
        else {
          break;
        }
      }
    }

    return $multiplier;
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Diversification";
  const NBR = 1;
  const DESCRIPTION = "Reach at least level 2 production in multiple industry sectors";
  const FAVOR_REFERENCE = [3 => 2, 4 => 5, 5 => 9, 6 => 12];
}