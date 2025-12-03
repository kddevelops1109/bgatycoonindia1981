<?php
namespace Bga\Games\tycoonindianew\Spec;

use Bga\Games\tycoonindianew\Contracts\Fungible;
use Bga\Games\tycoonindianew\Type\SpecType;
use Bga\Games\tycoonindianew\Type\TokenLocation;
use Bga\Games\tycoonindianew\Type\TokenTypeArg;

class TokenSpec implements Spec {

  public function __construct(
    public readonly TokenTypeArg $tokenTypeArg,
    public readonly TokenLocation $source,
    public readonly TokenLocation $target,
    public readonly ?array $tokenIds
  ) {}

  /**
   * Returns the tokens associated with this spec
   * @return array<Fungible>
   */
  public function getFungibles(): array {
    // TODO: Use Token Manager to retrieve the tokens for the token ids for this spec
    return [];
  }

  /**
   * Returns the type of spec, which is Token in this case
   * @return SpecType
   */
  public function getType(): SpecType {
    return SpecType::TOKEN;
  }
}