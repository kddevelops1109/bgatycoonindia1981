<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;
use Bga\Games\tycoonindianew\Model\Industrialist;

class Magnate extends CorporateAgendaCard {

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

      $sectorLevels = [];
      foreach ($sectors as $sector) {
        $sectorLevels[]= IndustrialistManager::getPlayerCounterValue($player_id, $sector);
      }

      rsort($sectorLevels);

      $secondHighestProductionLevel = $sectorLevels[1];

      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($secondHighestProductionLevel >= $threshold) {
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
  const NAME = "Magnate";
  const DESCRIPTION = "Reach a certain production level in any 2 industry sectors";
  const ENDGAME_FAVOR = [4 => 1, 5 => 4, 6 => 6, 7 => 9];
}