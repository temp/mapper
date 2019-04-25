<?php

declare(strict_types=1);

namespace Mapper\Constraint;

// phpcs:disable SlevomatCodingStandard.ControlStructures.DisallowEmpty.DisallowedEmpty
// phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter

/**
 * Is index empty
 */
final class IsArrayIndexEmpty implements Constraint
{
    private $index;

    /**
     * @param mixed $index
     */
    public function __construct($index)
    {
        $this->index = $index;
    }

    /**
     * @param mixed[] $record
     * @param mixed   $value
     */
    public function __invoke(array $record, $value): bool
    {
        return empty($value[$this->index]);
    }
}
