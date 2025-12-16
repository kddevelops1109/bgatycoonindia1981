<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Headline;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Card;

abstract class HeadlineCard extends Card {

  /**
   * TODO: Implement
   * @return void
   */
  public function applyEndgameFavor(int $player_id): void {
    // Do nothing
  }

  /**
   * TODO: Implement
   * @return void
   */
  public function applyEndgameInfluence(int $player_id): void {
    // Do nothing
  }

  /**
   * TODO: Implement
   * @return void
   */
  public function applyEndgameAssetValue(int $player_id): void {
    // Do nothing
  }

  /**
   * Headline cards cannot be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return false;
  }

  /**
   * Headline cards cannot be lost once gained
   * @return bool
   */
  public function canBeLost(): bool {
    return false;
  }

  /**
   * Constants - Filepath and Classpath
   */
  const FILEPATH = "/../../Headline/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Headline";
}