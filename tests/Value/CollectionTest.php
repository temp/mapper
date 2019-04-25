<?php

declare(strict_types=1);

namespace MapperTests\Value;

use Mapper\Value\Collection;
use Mapper\Value\Pick;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Value\Collection
 */
final class CollectionTest extends TestCase
{
    public function testWithNullSource(): void
    {
        $collection = new Collection(['abc' => null]);

        $result = $collection(['foo' => 'bar']);

        $this->assertSame(['abc' => null], $result);
    }

    public function testWithStringSource(): void
    {
        $collection = new Collection(['abc' => 'def']);

        $result = $collection(['foo' => 'bar']);

        $this->assertSame(['abc' => 'def'], $result);
    }

    public function testWithExpressionSource(): void
    {
        $collection = new Collection(['foo' => new Pick('foo'), 'bar' => new Pick('bar')]);

        $result = $collection(['foo' => 'abc', 'bar' => 'def', 'baz' => 'ghi']);

        $this->assertSame(['foo' => 'abc', 'bar' => 'def'], $result);
    }
}
