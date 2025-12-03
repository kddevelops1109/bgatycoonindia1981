<?php
namespace Bga\Games\tycoonindianew\Fungible;

class FungibleMetadata {
    public function __construct(
        public readonly bool $isGainable,
        public readonly bool $isDeductible,
        public readonly ?string $counterName
    ) {}
}