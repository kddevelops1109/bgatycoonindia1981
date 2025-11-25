<?php
namespace Bga\Games\tycoonindianew\CorporateAgendas;

use Bga\Games\tycoonindianew\Managers\IndustrialistsManager;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;

class Disinvestment extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function endgameFavor(): int {
    $favor = 0;

    $player_id = (int) $this->cardLocationArg;

    if (!is_null($player_id)) {
      $sharesRemaining = (int) IndustrialistsManager::getPlayerCounterValue($player_id, IndustrialistsManager::COUNTER_INDUSTRIALIST_SHARES_REMAINING);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($sharesRemaining == $threshold) {
          $favor = $_favor;
          break;
        }
      }
    }

    return $favor;
  }
  
  /**
   * Constants - Misc
   */
  const CARD_NAME = \clienttranslate("Disinvestment");
  const ENDGAME_FAVOR = [3 => 3, 2 => 6, 1 => 9, 0 => 13];
}