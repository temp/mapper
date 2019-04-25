<?php

declare(strict_types=1);

namespace Mapper;

use Mapper\Exception\ElementNotFound;
use function array_key_exists;
use function array_pop;
use function explode;

/**
 * Array accessor
 */
final class ArrayAccessor
{
    /**
     * @param mixed[] $data
     * @param mixed   $path
     */
    public function has(array $data, $path): bool
    {
        $elements = explode('.', $path);

        $current =& $data;
        foreach ($elements as $element) {
            if (!array_key_exists($element, $current)) {
                return false;
            }

            $current = $current[$element];
        }

        return true;
    }

    /**
     * @param mixed[] $data
     * @param mixed   $path
     *
     * @return mixed
     */
    public function get(array $data, $path)
    {
        $elements = explode('.', $path);

        $current =& $data;
        foreach ($elements as $element) {
            if (!array_key_exists($element, $current)) {
                throw ElementNotFound::createFromElement($element);
            }

            $current = $current[$element];
        }

        return $current;
    }

    /**
     * @param mixed[] $data
     * @param mixed   $path
     * @param mixed   $value
     */
    public function set(array &$data, $path, $value): void
    {
        $elements = explode('.', $path);
        $index = array_pop($elements);
        $current =& $data;

        foreach ($elements as $element) {
            if (!isset($current[$element])) {
                $current[$element] = [];
            }

            $current =& $current[$element];
        }

        $current[$index] = $value;
    }

    /**
     * @param mixed[] $data
     * @param mixed   $path
     */
    public function remove(array &$data, $path): void
    {
        $elements = explode('.', $path);
        $index = array_pop($elements);
        $current =& $data;

        foreach ($elements as $element) {
            if (!isset($current[$element])) {
                throw ElementNotFound::createFromElement($element);
            }

            $current =& $current[$element];
        }

        if (!isset($current[$index])) {
            throw ElementNotFound::createFromElement($index);
        }

        unset($current[$index]);
    }
}
