<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\DeckItem\Card\CorporateAgendaCard;

class Industrialization extends CorporateAgendaCard {

  /**
   * Obtain endgame favor for given player based on their endgame money in hand
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameFavorMultiplier(int $playerId): float {
    $multiplier = 0.0;

    // If the player is the owner of the corporate agenda, then evaluate and return specific multiplier
    if (!is_null($playerId) && $playerId === $this->cardLocationArg) {
      $built_plants = (int) IndustrialistManager::getPlayerCounterValue($playerId, IndustrialistManager::COUNTER_INDUSTRIALIST_BUILT_PLANTS);
      foreach (self::ENDGAME_FAVOR as $threshold => $favor) {
        if ($built_plants >= $threshold) {
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
  const NAME = "Industrialization";
  const NBR = 1;
  const DESCRIPTION = "Build a lot of plants on the map";
  const ENDGAME_FAVOR = [6 => 1, 7 => 4, 9 => 7, 9 => 11];
}