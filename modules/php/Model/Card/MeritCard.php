<?php
namespace Bga\Games\tycoonindianew\Model\Card;

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
   * Constants - Misc
   */
  const NUM_CARDS = 30;
  const CARD_TYPE = "Merit";
  const CARD_TYPE_ARG = 5;

  /**
   * Constants - Filepath and Classpath
   */
  const FILEPATH = "/../../Merit/list.inc.php";
  const CLASSPATH = "\Bga\Games\\tycoonindianew\Merit";
}