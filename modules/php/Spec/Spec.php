<?php
namespace Bga\Games\tycoonindianew\Spec;

use Bga\Games\tycoonindianew\Contracts\Fungible;
use Bga\Games\tycoonindianew\Type\SpecType;

interface Spec {

  /**
   * Returns the fungibles associated with this spec
   * @return array<Fungible> Array of fungibles
   */
  public function getFungibles(): array;

  /**
   * Gets the type of spec this represents
   * @return SpecType
   */
  public function getType(): SpecType;
}