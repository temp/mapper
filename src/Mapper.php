<?php

declare(strict_types=1);

namespace Mapper;

/**
 * Field mapper
 */
final class Mapper
{
    private $steps;

    public function __construct(Expression ...$steps)
    {
        $this->steps = $steps;
    }

    /**
     * @param mixed[] $record
     *
     * @return mixed
     */
    public function __invoke(array $record)
    {
        foreach ($this->steps as $step) {
            $record = $step($record);
        }

        return $record;
    }
}
