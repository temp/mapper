<?php

declare(strict_types=1);

namespace Mapper;

use Mapper\Exception\ElementNotFound;
use Mapper\Helper\Assert;
use function implode;
use function Safe\substr;

function always($arg): callable {
    return static function() use ($arg) {
        return $arg;
    };
}

function arr($config): callable {
    return static function ($value) use ($config) {
        return map(static function($f) use ($value) {
            return $f($value);
        }, $config);
    };
}

function compose(callable ...$args): callable {
    return static function($value) use ($args) {
        return array_reduce(array_reverse($args), static function($carry, $arg) {
            return $arg($carry);
        }, $value);
    };
}

function converge(callable $fn, array $sources): callable {
    Assert::allCallableOrScalar($sources);

    return static function ($value) use ($fn, $sources) {
        $data = [];
        foreach ($sources as $source) {
            $data[] = $source($value);
        }

        return $fn(...$data);
    };
}

function curry2(callable $fn): callable {
    return static function (...$args) use ($fn) {
        switch (count($args)) {
            case 0:
                die("nope");
            case 1:
                return static function ($b) use ($args, $fn) {
                    return $fn($args[0], $b);
                };
            case 2:
                return $fn(...$args);
            default:
                return $fn(...[$args[0], $args[1]]);
        }
    };
}

function drop(int $length): callable {
    return static function ($value) use ($length) {
        if (is_array($value)) {
            return array_slice($value, $length);
        }

        return substr($value, $length);
    };
}

/**
 * @param mixed $condition
 * @param mixed $true
 * @param mixed $false
 */
function ifElse($condition, $true, $false): callable {
    Assert::callableOrScalar($condition);
    Assert::nullOrCallableOrScalar($true);
    Assert::nullOrCallableOrScalar($false);

    return static function($value) use ($condition, $true, $false) {
        if (!is_callable($condition)) {
            $result = $condition;
        } else {
            $result = $condition($value);
        }

        if ($result) {
            if (!is_callable($true)) {
                return $true;
            }

            return $true($value);
        }

        if (!is_callable($false)) {
            return $false;
        }

        return $false($value);
    };
}

function isEmpty(): callable
{
    return static function($value): bool {
        return empty($value);
    };
}

function join(string $glue): callable {
    return static function (... $values) use ($glue) {
        return implode($glue, $values);
    };
}


function map(callable $fn, ...$args) {
    return array_map($fn, ... $args);
}

function merge(): callable {
    return static function (... $args) {
        return array_merge(... $args);
    };
}

function omit($source) {
    return static function ($value) use ($source) {
        foreach ($source as $key) {
            unset($value[$key]);
        }

        return $value;
    };
}

function pipe (callable ...$args): callable {
    return static function($value) use ($args) {
        return array_reduce($args, static function($carry, $arg) {
            return $arg($carry);
        }, $value);
    };
}

function prop($field): callable
{
    return static function ($value) use ($field) {
        if (!isset($value[$field])) {
            throw ElementNotFound::createFromElement($field);
        }

        return $value[$field];
    };
}

function take (int $length): callable {
    return static function($value) use ($length) {
        if (is_array($value)) {
            return array_slice($value, 0, $length);
        }

        return substr($value, 0, $length);
    };
}
