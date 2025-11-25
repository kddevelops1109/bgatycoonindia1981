<?php
namespace Bga\Games\tycoonindianew\CorporateAgendas;

use Bga\Games\tycoonindianew\Managers\IndustrialistsManager;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;

class Industrialization extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function endgameFavor(): int {
    $favor = 0;

    $player_id = (int) $this->cardLocationArg;

    if (!is_null($player_id)) {
      $built_plants = (int) IndustrialistsManager::getPlayerCounterValue($player_id, IndustrialistsManager::COUNTER_INDUSTRIALIST_BUILT_PLANTS);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($built_plants >= $threshold) {
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
  const CARD_NAME = \clienttranslate("Industrialization");
  const ENDGAME_FAVOR = [6 => 1, 7 => 4, 9 => 7, 9 => 11];
}