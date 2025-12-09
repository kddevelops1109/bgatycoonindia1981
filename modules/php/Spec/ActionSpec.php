<?php
namespace Bga\Games\tycoonindianew\Spec;

use Bga\Games\tycoonindianew\Action\Action;
use Bga\Games\tycoonindianew\Type\SpecType;

class ActionSpec implements Spec {

  public function __construct(
    public readonly Action $action
  ) {}

  /**
   * Returns the fungibles associated with this spec
   * @return array<Fungible> Array of fungibles
   */
  public function getFungibles(): array {
    return [$this->action];
  }

  /**
   * Gets the type of spec this represents
   * @return SpecType
   */
  public function getType(): SpecType {
    return SpecType::ACTION;
  }
}