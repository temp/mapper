<?php

declare(strict_types=1);

namespace Mapper\Value;

use Mapper\Expression;

/**
 * Value interface
 */
interface Value extends Expression
{
    /**
     * @param mixed[] $record
     *
     * @return mixed
     */
    public function __invoke(array $record);
}
