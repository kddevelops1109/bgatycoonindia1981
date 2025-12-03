<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;

class Disinvestment extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function applyEndgameFavor(int $player_id): void {
    $favor = 0;

    if (!is_null($player_id)) {
      $sharesRemaining = (int) IndustrialistManager::getPlayerCounterValue($player_id, IndustrialistManager::COUNTER_INDUSTRIALIST_SHARES_REMAINING);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($sharesRemaining == $threshold) {
          $favor = $_favor;
          break;
        }
      }

      $this->applyEndgameFavorEffect($player_id, $favor);
    }
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Disinvestment";
  const DESCRIPTION = "Have less shares remaining of your own color";
  const ENDGAME_FAVOR = [3 => 3, 2 => 6, 1 => 9, 0 => 13];
}