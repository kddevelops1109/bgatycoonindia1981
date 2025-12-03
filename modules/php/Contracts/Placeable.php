<?php
namespace Bga\Games\tycoonindianew\Contracts;

/**
 * Represents something that can be placed in an occupiable space
 * @template T of Occupiable
 */
interface Placeable {

  /**
   * Place this placeable object at the given occupiable
   * @param T $occupiable
   * @return void
   */
  public function place(Occupiable $occupiable);
}