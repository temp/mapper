<?php

declare(strict_types=1);

namespace Mapper\Value;

use function is_array;
use function is_scalar;
use function Safe\substr;

// phpcs:disable SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingTraversableReturnTypeHintSpecification

/**
 * Right
 */
final class Right implements Value
{
    private $length;
    private $source;

    /**
     * @param mixed $source
     */
    public function __construct(int $length, $source)
    {
        $this->length = $length;
        $this->source = $source;
    }

    /**
     * @param mixed[] $record
     *
     * @return mixed
     */
    public function __invoke(array $record)
    {
        $value = $this->value($record, $this->source);

        return $this->modify($record, $value);
    }

    /**
     * @param mixed[] $record
     * @param mixed   $source
     *
     * @return array|string
     */
    private function value(array $record, $source)
    {
        if (is_array($source)) {
            $collection = [];
            foreach ($source as $key => $value) {
                $collection[$key] = $this->value($record, $value);
            }

            return $collection;
        }

        if (is_scalar($source)) {
            return substr((string) $source, 0 - $this->length);
        }

        return substr($source($record), 0 - $this->length);
    }

    /**
     * @param mixed[] $record
     * @param mixed   $value
     *
     * @return array|string
     */
    private function modify(array $record, $value)
    {
        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                $value[$subKey] = $this->modify($record, $subValue);
            }

            return $value;
        }

        return substr($value, 0 - $this->length);
    }
}
