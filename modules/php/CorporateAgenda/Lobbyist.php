<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;

class Lobbyist extends CorporateAgendaCard {

  /**
   * Obtain endgame favor for given player based on their endgame money in hand
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameFavorMultiplier(int $playerId): float {
    $multiplier = 0.0;

    // If the player is the owner of the corporate agenda, then evaluate and return specific multiplier
    if (!is_null($playerId) && $playerId === $this->cardLocationArg) {
      $policies_gained = (int) IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_POLICIES_GAINED);
      foreach (self::FAVOR_REFERENCE as $threshold => $favor) {
        if ($policies_gained >= $threshold) {
          $multiplier = $favor;
        }
        else {
          break;
        }
      }
    }

    return $multiplier;
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Lobbyist";
  const NBR = 1;
  const DESCRIPTION = "Own a lot of policies";
  const FAVOR_REFERENCE = [4 => 2, 5 => 5, 6 => 8, 7 => 10];
}