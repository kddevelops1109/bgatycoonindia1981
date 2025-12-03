<?php
namespace Bga\Games\tycoonindianew\Promise;

use Bga\Games\tycoonindianew\Model\DBObject as DBO;

/**
 * This interface represents a promise to take/deliver any fungible from a player, such as:
 * - Influence
 * - Money
 * - Asset Value
 * - Promoters (Hand/Pool)
 * - Favor
 * - Shares
 * - Policies
 * - Corporate Agendas
 * - Industries
 * - Promissary Notes
 * @property string $id ID of the promise
 * @property bool $isOptional Is this promise optional? Defaults to false
 */
abstract class Promise extends DBO {

  protected function __construct(
    public readonly string $id,
    public readonly bool $isOptional = false
  ) {}
}