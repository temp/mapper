<?php

declare(strict_types=1);

namespace Mapper\Value;

use function is_scalar;

/**
 * Collection
 */
final class Collection implements Value
{
    private $source;

    /**
     * @param mixed[] $source
     */
    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /**
     * @param mixed[] $record
     *
     * @return mixed
     */
    public function __invoke(array $record)
    {
        $collection = [];
        foreach ($this->source as $key => $value) {
            $collection[$key] = $this->source($record, $value);
        }

        return $collection;
    }

    /**
     * @param mixed[] $record
     * @param mixed   $source
     *
     * @return mixed
     */
    private function source(array $record, $source)
    {
        if ($source === null) {
            return null;
        }

        if (is_scalar($source)) {
            return $source;
        }

        return $source($record);
    }
}
