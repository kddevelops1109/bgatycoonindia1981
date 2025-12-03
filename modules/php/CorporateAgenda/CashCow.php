<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;

class CashCow extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function applyEndgameFavor(int $player_id): void {
    $favor = 0;

    if (!is_null($player_id)) {
      $money = (int) IndustrialistManager::getPlayerCounterValue($player_id, IndustrialistManager::COUNTER_INDUSTRIALIST_MONEY);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($money >= $threshold) {
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
  const NAME = "Cash Cow";
  const DESCRIPTION = "Have a lot of leftover money";
  const ENDGAME_FAVOR = [30 => 1, 60 => 4, 100 => 8, 150 => 14];
}