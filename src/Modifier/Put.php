<?php

declare(strict_types=1);

namespace Mapper\Modifier;

use Mapper\ArrayAccessor;
use Mapper\Constraint\Constraint;
use function is_scalar;

/**
 * Pick
 */
final class Put implements Modifier
{
    private $field;
    private $source;
    private $constraint;

    /**
     * @param mixed $source
     */
    public function __construct(string $field, $source, ?Constraint $constraint = null)
    {
        $this->field = $field;
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
        $value = $this->value($record, $this->source);

        if ($this->constraint && !$this->constraint($record, $value, $this->constraint)) {
            return $record;
        }

        $accessor = new ArrayAccessor();
        $accessor->set($record, $this->field, $value);

        return $record;
    }

    /**
     * @param mixed[] $record
     * @param mixed   $source
     *
     * @return mixed
     */
    private function value(array $record, $source)
    {
        if ($source === null) {
            return null;
        }

        if (is_scalar($source)) {
            return $source;
        }

        return $source($record);
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
