<?php

declare(strict_types=1);

namespace MapperTests\Value;

use Mapper\Value\Pick;
use Mapper\Value\Right;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Value\Right
 */
final class RightTest extends TestCase
{
    public function testWithStringSource(): void
    {
        $right = new Right(3, 'foobar');

        $result = $right(['foo' => 'bar']);

        $this->assertSame('bar', $result);
    }

    public function testWithArraySource(): void
    {
        $right = new Right(3, ['foobar', 'barbaz']);

        $result = $right(['foo' => 'bar']);

        $this->assertSame(['bar', 'baz'], $result);
    }

    public function testWithExpressionSource(): void
    {
        $right = new Right(4, new Pick('foo'));

        $result = $right(['foo' => 'barbaz']);

        $this->assertSame('rbaz', $result);
    }
}
