<?php
namespace Bga\Games\tycoonindianew\Model\DeckItem\Card\Merit;

use Bga\Games\tycoonindianew\Model\DeckItem\Card\Card;

abstract class MeritCard extends Card {

  /**
   * Merit cards can be gained
   * @return bool
   */
  public function canBeGained(): bool {
    return true;
  }

  /**
   * Merit cards can be lost
   * @return bool
   */
  public function canBeLost(): bool {
    return true;
  }

  /**
   * Constants - Filepath and Classpath
   */
  const FILEPATH = "/../../Merit/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Merit";
}