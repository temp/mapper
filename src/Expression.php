<?php

declare(strict_types=1);

namespace Mapper;

/**
 * Field mapper
 */
interface Expression
{
    /**
     * @param mixed[] $record
     *
     * @return mixed
     */
    public function __invoke(array $record);
}
