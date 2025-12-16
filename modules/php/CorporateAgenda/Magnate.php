<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\CorporateAgendaCard;

class Magnate extends CorporateAgendaCard {

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

      $sectorLevels = [];
      foreach ($sectors as $sector) {
        $sectorLevels[]= IndustrialistManager::getPlayerCounterValue($playerId, $sector);
      }

      rsort($sectorLevels);

      $secondHighestProductionLevel = $sectorLevels[1];

      foreach (self::FAVOR_REFERENCE as $threshold => $favor) {
        if ($secondHighestProductionLevel >= $threshold) {
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
  const NAME = "Magnate";
  const NBR = 1;
  const DESCRIPTION = "Reach a certain production level in any 2 industry sectors";
  const FAVOR_REFERENCE = [4 => 1, 5 => 4, 6 => 6, 7 => 9];
}