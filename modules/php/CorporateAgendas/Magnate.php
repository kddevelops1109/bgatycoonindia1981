<?php
namespace Bga\Games\tycoonindianew\CorporateAgendas;

use Bga\Games\tycoonindianew\Managers\IndustrialistsManager;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;
use Bga\Games\tycoonindianew\Models\Industrialist;

class Magnate extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function endgameFavor(): int {
    $favor = 0;

    $player_id = (int) $this->cardLocationArg;

    if (!is_null($player_id)) {
      $sectors = [
        IndustrialistsManager::COUNTER_INDUSTRIALIST_FINANCE,
        IndustrialistsManager::COUNTER_INDUSTRIALIST_MINERALS,
        IndustrialistsManager::COUNTER_INDUSTRIALIST_FUEL,
        IndustrialistsManager::COUNTER_INDUSTRIALIST_AGRO,
        IndustrialistsManager::COUNTER_INDUSTRIALIST_POWER,
        IndustrialistsManager::COUNTER_INDUSTRIALIST_TRANSPORT
      ];

      $sectorLevels = [];
      foreach ($sectors as $sector) {
        $sectorLevels[]= IndustrialistsManager::getPlayerCounterValue($player_id, $sector);
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
    }

    return $favor;
  }
  
  /**
   * Constants - Misc
   */
  const CARD_NAME = \clienttranslate("Magnate");
  const ENDGAME_FAVOR = [4 => 1, 5 => 4, 6 => 6, 7 => 9];
}