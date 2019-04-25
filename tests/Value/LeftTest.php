<?php

declare(strict_types=1);

namespace MapperTests\Value;

use Mapper\Value\Left;
use Mapper\Value\Pick;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Value\Left
 */
final class LeftTest extends TestCase
{
    public function testWithStringSource(): void
    {
        $left = new Left(4, 'foobar');

        $result = $left(['foo' => 'bar']);

        $this->assertSame('foob', $result);
    }

    public function testWithArraySource(): void
    {
        $left = new Left(3, ['foobar', 'barbaz']);

        $result = $left(['foo' => 'bar']);

        $this->assertSame(['foo', 'bar'], $result);
    }

    public function testWithExpressionSource(): void
    {
        $left = new Left(4, new Pick('foo'));

        $result = $left(['foo' => 'barbaz']);

        $this->assertSame('barb', $result);
    }
}
