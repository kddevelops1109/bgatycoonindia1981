<?php
namespace Bga\Games\tycoonindianew\Contracts;

/**
 * Definition of an identity-based fungible such as a card or a token (not a numeric one such as influence or money)
 */
interface Fungible {

  /**
   * Can this fungible be gained or drawn by players
   * @return bool
   */
  public function canBeGained(): bool;

  /**
   * Can this fungible be lost or discarded by players
   * @return bool
   */
  public function canBeLost(): bool;
}