<?php

declare(strict_types=1);

namespace MapperTests\Value;

use Mapper\Value\Join;
use Mapper\Value\Pick;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Value\Join
 */
final class JoinTest extends TestCase
{
    public function testWithEmptySource(): void
    {
        $join = new Join('_', []);

        $result = $join(['foo' => 'bar']);

        $this->assertSame('', $result);
    }

    public function testWithStringSource(): void
    {
        $pick = new Join('_', ['foo', 'bar']);

        $result = $pick(['foo' => ['bar' => 'baz']]);

        $this->assertSame('foo_bar', $result);
    }

    public function testWithExpressionSource(): void
    {
        $pick = new Join('_', [new Pick('foo'), new Pick('bar')]);

        $result = $pick(['foo' => 'abc', 'bar' => 'def']);

        $this->assertSame('abc_def', $result);
    }
}
