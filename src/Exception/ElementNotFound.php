<?php

declare(strict_types=1);

namespace Mapper\Exception;

use InvalidArgumentException;
use function Safe\sprintf;

/**
 * Element not found
 */
final class ElementNotFound extends InvalidArgumentException
{
    /**
     * @param mixed $element
     */
    public static function createFromElement($element): self
    {
        return new self(sprintf('Element %s not found.', $element));
    }
}
