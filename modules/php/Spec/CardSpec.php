<?php
namespace Bga\Games\tycoonindianew\Spec;

use Bga\Games\tycoonindianew\Contracts\Fungible;
use Bga\Games\tycoonindianew\Type\CardLocation;
use Bga\Games\tycoonindianew\Type\CardTypeArg;
use Bga\Games\tycoonindianew\Type\SpecType;

class CardSpec implements Spec {

  public function __construct(
    public readonly CardTypeArg $cardTypeArg,
    public readonly CardLocation $source,
    public readonly ?CardLocation $target,
    public readonly ?array $cardIds
  ) {}

  /**
   * Returns the cards associated with this spec
   * @return array<Fungible>
   */
  public function getFungibles(): array {
    // TODO: Use Card Manager to retrieve the cards for the card ids for this spec
    return [];
  }

  /**
   * Returns the type of spec, which is Card in this case
   * @return SpecType
   */
  public function getType(): SpecType {
    return SpecType::CARD;
  }
}