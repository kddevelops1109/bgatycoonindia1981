<?php
namespace Bga\Games\tycoonindianew\Manager;

interface Manager {

  /**
   * New game setup for given set of players
   * @param array $players
   * @return void
   */
  public function setupNewGame(array $players);
}