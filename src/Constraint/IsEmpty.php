<?php

declare(strict_types=1);

namespace Mapper\Constraint;

// phpcs:disable SlevomatCodingStandard.ControlStructures.DisallowEmpty.DisallowedEmpty
// phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter

/**
 * Is empty
 */
final class IsEmpty implements Constraint
{
    /**
     * @param mixed[] $record
     * @param mixed   $value
     */
    public function __invoke(array $record, $value): bool
    {
        return empty($value);
    }
}
