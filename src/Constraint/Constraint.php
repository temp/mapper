<?php

declare(strict_types=1);

namespace Mapper\Constraint;

/**
 * Constraint interface
 */
interface Constraint
{
    /**
     * @param mixed[] $record
     * @param mixed   $value
     */
    public function __invoke(array $record, $value): bool;
}
