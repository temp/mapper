<?php

declare(strict_types=1);

namespace Mapper\Helper;

use function is_array;
use function is_callable;
use function is_scalar;

/**
 * Array accessor
 */
final class Assert
{
    /**
     * @param mixed $value
     */
    public static function callable($value): void
    {
        if (!is_callable($value)) {
            throw new \RuntimeException('Not a callable');
        }
    }

    /**
     * @param mixed $value
     */
    public static function scalar($value): void
    {
        if (!is_scalar($value)) {
            throw new \RuntimeException('Not a scalar');
        }
    }

    /**
     * @param mixed $value
     */
    public static function callableOrScalar($value): void
    {
        if (!is_scalar($value) && !is_callable($value)) {
            throw new \RuntimeException('Not a callable or a scalar');
        }
    }

    /**
     * @param mixed $value
     */
    public static function nullOrCallableOrScalar($value): void
    {
        if (!is_null($value) && !is_scalar($value) && !is_callable($value)) {
            throw new \RuntimeException('Not a callable or a scalar');
        }
    }

    /**
     * @param mixed $values
     */
    public static function allScalar($values): void
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        foreach ($values as $value) {
            self::scalar($value);
        }
    }

    /**
     * @param mixed $values
     */
    public static function allCallableOrScalar($values): void
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        foreach ($values as $value) {
            self::callableOrScalar($value);
        }
    }

    /**
     * @param mixed $values
     */
    public static function allNullOrCallableOrScalar($values): void
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        foreach ($values as $value) {
            self::nullOrCallableOrScalar($value);
        }
    }
}
