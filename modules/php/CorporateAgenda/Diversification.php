<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;
use Bga\Games\tycoonindianew\Model\Industrialist;

class Diversification extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function applyEndgameFavor(int $player_id): void {
    $favor = 0;

    if (!is_null($player_id)) {
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
        $sectorLevel = IndustrialistManager::getPlayerCounterValue($player_id, $sector);
        if ($sectorLevel >= 2) {
          $numSectors++;
        }
      }

      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($numSectors >= $threshold) {
          $favor = $_favor;
        }
        else {
          break;
        }
      }

      $this->applyEndgameFavorEffect($player_id, $favor);
    }
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Diversification";
  const DESCRIPTION = "Reach at least level 2 production in multiple industry sectors";
  const ENDGAME_FAVOR = [3 => 2, 4 => 5, 5 => 9, 6 => 12];
}