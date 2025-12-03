<?php
namespace Bga\Games\tycoonindianew\Model\Card\Industry;

use Bga\Games\tycoonindianew\Model\Card\Card;

abstract class IndustryCard extends Card {

  /**
   * Industry cards can be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return true;
  }

  /**
   * Industry cards cannot be lost once gained
   * @return bool
   */
  public function canBeLost(): bool {
    return false;
  }

  /**
   * Industry cards do not give an endgame favor
   * @return int
   */
  public function applyEndgameFavor(int $player_id): void {
    // Do nothing
  }

  /**
   * Industry cards do not give an endgame influence by themselves (only via policy cards)
   * @return int
   */
  public function applyEndgameInfluence(int $player_id): void {
    // Do nothing
  }

  /**
   * Constants - Filepath and Classpath
   */
  const FILEPATH = "/../../Industry/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Industry";
}