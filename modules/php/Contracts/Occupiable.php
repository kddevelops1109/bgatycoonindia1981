<?php
namespace Bga\Games\tycoonindianew\Contracts;

/**
 * Represents occupiable spaces on the board, where tokens can occupy them
 * @template T of Placeable
 */
interface Occupiable {

  /**
   * Implement occupation of given placeable in this occupiable
   * @param T $placeable
   * @return void
   */
  public function occupy(Placeable $placeable);

  /**
   * Placeable in this occupiable vacates it
   * @return void
   */
  public function vacate();
}