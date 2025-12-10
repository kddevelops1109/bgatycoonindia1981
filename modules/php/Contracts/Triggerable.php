<?php
namespace Bga\Games\tycoonindianew\Contracts;

interface Triggerable {

  /**
   * Fire this triggerable for given player
   * @param int $playerId
   * @return void
   */
  public function fire(int $playerId): void;
}