<?php

declare(strict_types=1);

namespace Mapper\Value;

use function is_array;
use function is_scalar;
use function Safe\substr;

// phpcs:disable SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingTraversableReturnTypeHintSpecification

/**
 * Left
 */
final class Left implements Value
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
        return $this->value($record, $this->source);
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
            return substr((string) $source, 0, $this->length);
        }

        return substr((string) $source($record), 0, $this->length);
    }
}
