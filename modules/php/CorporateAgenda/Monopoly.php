<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\CorporateAgendaCard;

class Monopoly extends CorporateAgendaCard {

  /**
   * Obtain endgame favor for given player based on their endgame money in hand
   * @param int $playerId
   * @return float
   */
  public function obtainEndgameFavorMultiplier(int $playerId): float {
    $multiplier = 0.0;

    // If the player is the owner of the corporate agenda, then evaluate and return specific multiplier
    if (!is_null($playerId) && $playerId === $this->cardLocationArg) {
      // TODO: Implement
    }

    return $multiplier;
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Monopoly";
  const NBR = 1;
  const DESCRIPTION = "Own a lot of industry cards of the same sector";
  const FAVOR_REFERENCE = [30 => 1, 60 => 4, 100 => 8, 150 => 14];
}