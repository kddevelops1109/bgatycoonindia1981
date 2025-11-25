<?php
namespace Bga\Games\tycoonindianew\CorporateAgendas;

use Bga\Games\tycoonindianew\Managers\IndustrialistsManager;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;

class Lobbyist extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function endgameFavor(): int {
    $favor = 0;

    $player_id = (int) $this->cardLocationArg;

    if (!is_null($player_id)) {
      $policies_gained = (int) IndustrialistsManager::getPlayerCounterValue($player_id, IndustrialistsManager::COUNTER_INDUSTRIALIST_POLICIES_GAINED);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($policies_gained >= $threshold) {
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
  const CARD_NAME = \clienttranslate("Lobbyist");
  const ENDGAME_FAVOR = [4 => 2, 5 => 5, 6 => 8, 7 => 10];
}