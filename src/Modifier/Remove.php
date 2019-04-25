<?php

declare(strict_types=1);

namespace Mapper\Modifier;

use Mapper\ArrayAccessor;
use Mapper\Constraint\Constraint;
use function is_array;

// phpcs:disable SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint

/**
 * Pick
 */
final class Remove implements Modifier
{
    private $source;
    private $constraint;

    /**
     * @param mixed $source
     */
    public function __construct($source, ?Constraint $constraint = null)
    {
        $this->source = $source;
        $this->constraint = $constraint;
    }

    /**
     * @param mixed[] $record
     *
     * @return mixed[]
     */
    public function __invoke(array $record): array
    {
        $record = $this->modify($record, $this->source);

        return $record;
    }

    /**
     * @param mixed[] $record
     * @param mixed   $source
     *
     * @return mixed[]
     */
    private function modify(array $record, $source)
    {
        $accessor = new ArrayAccessor();

        if (is_array($source)) {
            foreach ($source as $key) {
                $record = $this->modify($record, $key);
            }

            return $record;
        }

        if (!$accessor->has($record, $source)) {
            return $record;
        }

        if ($this->constraint && !$this->constraint($record, $accessor->get($record, $source), $this->constraint)) {
            return $record;
        }

        $accessor->remove($record, $source);

        return $record;
    }

    /**
     * @param mixed[] $record
     * @param mixed   $value
     * @param mixed   $constraint
     */
    private function constraint(array $record, $value, $constraint): bool
    {
        return $constraint($record, $value);
    }
}
