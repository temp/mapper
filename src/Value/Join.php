<?php

declare(strict_types=1);

namespace Mapper\Value;

use function implode;
use function is_string;

/**
 * Join
 */
final class Join implements Value
{
    private $glue;
    private $source;

    /**
     * @param mixed[] $source
     */
    public function __construct(string $glue, array $source)
    {
        $this->glue = $glue;
        $this->source = $source;
    }

    /**
     * @param mixed[] $record
     *
     * @return mixed
     */
    public function __invoke(array $record)
    {
        $values = [];

        foreach ($this->source as $field) {
            if (is_string($field)) {
                $values[] = $field;
            } else {
                $values[] = $field($record);
            }
        }

        return implode($this->glue, $values);
    }
}
