<?php

declare(strict_types=1);

namespace Mapper\Value;

use Mapper\ArrayAccessor;

// phpcs:disable SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint

/**
 * Pick
 */
final class Pick implements Value
{
    private $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @param mixed[] $record
     *
     * @return mixed
     */
    public function __invoke(array $record)
    {
        $accessor = new ArrayAccessor();

        return $accessor->get($record, $this->field);
    }
}
