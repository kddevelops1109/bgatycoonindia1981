<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;

class Disinvestment extends CorporateAgendaCard {

  /**
   * Obtain endgame favor for given player based on their endgame money in hand
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameFavorMultiplier(int $playerId): float {
    $multiplier = 0.0;

    // If the player is the owner of the corporate agenda, then evaluate and return specific multiplier
    if (!is_null($playerId) && $playerId === $this->cardLocationArg) {
      $sharesRemaining = (int) IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_SHARES_REMAINING);
      foreach (self::FAVOR_REFERENCE as $threshold => $favor) {
        if ($sharesRemaining == $threshold) {
          $multiplier = $favor;
          break;
        }
      }
    }

    return $multiplier;
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Disinvestment";
  const NBR = 1;
  const DESCRIPTION = "Have less shares remaining of your own color";
  const FAVOR_REFERENCE = [3 => 3, 2 => 6, 1 => 9, 0 => 13];
}