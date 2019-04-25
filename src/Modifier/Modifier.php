<?php

declare(strict_types=1);

namespace Mapper\Modifier;

use Mapper\Expression;

/**
 * Modifier interface
 */
interface Modifier extends Expression
{
    /**
     * @param mixed[] $record
     *
     * @return mixed[]
     */
    public function __invoke(array $record): array;
}
