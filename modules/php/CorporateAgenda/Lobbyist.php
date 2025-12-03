<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;

class Lobbyist extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function applyEndgameFavor(int $player_id): void {
    $favor = 0;

    if (!is_null($player_id)) {
      $policies_gained = (int) IndustrialistManager::getPlayerCounterValue($player_id, IndustrialistManager::COUNTER_INDUSTRIALIST_POLICIES_GAINED);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($policies_gained >= $threshold) {
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
  const NAME = "Lobbyist";
  const DESCRIPTION = "Own a lot of policies";
  const ENDGAME_FAVOR = [4 => 2, 5 => 5, 6 => 8, 7 => 10];
}