<?php
namespace Bga\Games\tycoonindianew\Filter;

use Bga\Games\tycoonindianew\Registry\Entry;
use Bga\Games\tycoonindianew\Type\FilterType;

/**
 * Represents a database filter.
 * It can be entered into a registry.
 */
abstract class DBFilter implements Entry {

    /**
     * Type of filter, i.e., simple or composite.
     *
     * @var FilterType
     */
    protected FilterType $type;

    public function __construct(FilterType $type) {
        $this->type = $type;
    }

    /**
     * Builds a string representing this filter that can be plugged into a DB query.
     */
    abstract public function build(): string;

    abstract public function stringify();
}
