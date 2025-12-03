<?php
namespace Bga\Games\tycoonindianew\CorporateAgenda;

use Bga\Games\tycoonindianew\Manager\IndustrialistManager;
use Bga\Games\tycoonindianew\Model\Card\CorporateAgendaCard;

class Monopoly extends CorporateAgendaCard {

  /**
   * Returns the end game favor this corporate agenda card gives to eligible player(s)
   * @return int End game favor
   */
  public function applyEndgameFavor(int $player_id): void {
    $favor = 0;

    if (!is_null($player_id)) {
      $this->applyEndgameFavorEffect($player_id, $favor);
    }
  }
  
  /**
   * Constants - Misc
   */
  const NAME = "Monopoly";
  const DESCRIPTION = "Own a lot of industry cards of the same sector";
  const ENDGAME_FAVOR = [30 => 1, 60 => 4, 100 => 8, 150 => 14];
}