<?php
namespace Bga\Games\tycoonindianew\CorporateAgendas;

use Bga\Games\tycoonindianew\Managers\IndustrialistsManager;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;
use Bga\Games\tycoonindianew\Models\Industrialist;

class Diversification extends CorporateAgendaCard {

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

      $numSectors = 0;
      
      foreach ($sectors as $sector) {
        $sectorLevel = IndustrialistsManager::getPlayerCounterValue($player_id, $sector);
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
    }

    return $favor;
  }
  
  /**
   * Constants - Misc
   */
  const CARD_NAME = \clienttranslate("Diversification");
  const ENDGAME_FAVOR = [3 => 2, 4 => 5, 5 => 9, 6 => 12];
}