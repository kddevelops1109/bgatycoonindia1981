<?php
namespace Bga\Games\tycoonindianew\CorporateAgendas;

use Bga\Games\tycoonindianew\Managers\IndustrialistsManager;
use Bga\Games\tycoonindianew\Models\Cards\CorporateAgendaCard;

class CashCow extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function endgameFavor(): int {
    $favor = 0;

    $player_id = (int) $this->cardLocationArg;

    if (!is_null($player_id)) {
      $money = (int) IndustrialistsManager::getPlayerCounterValue($player_id, IndustrialistsManager::COUNTER_INDUSTRIALIST_MONEY);
      foreach (self::ENDGAME_FAVOR as $threshold => $_favor) {
        if ($money >= $threshold) {
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
  const CARD_NAME = \clienttranslate("Cash Cow");
  const ENDGAME_FAVOR = [30 => 1, 60 => 4, 100 => 8, 150 => 14];
}