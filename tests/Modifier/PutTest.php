<?php

declare(strict_types=1);

namespace MapperTests\Modifier;

use Mapper\Constraint\IsEmpty;
use Mapper\Modifier\Put;
use Mapper\Value\Pick;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Modifier\Put
 */
final class PutTest extends TestCase
{
    public function testNull(): void
    {
        $put = new Put('bar', null);

        $result = $put(['foo' => 'abc']);

        $this->assertSame(['foo' => 'abc', 'bar' => null], $result);
    }

    public function testSimple(): void
    {
        $put = new Put('bar', 'def');

        $result = $put(['foo' => 'abc']);

        $this->assertSame(['foo' => 'abc', 'bar' => 'def'], $result);
    }

    public function testNested(): void
    {
        $put = new Put('bar.baz', 'def');

        $result = $put(['foo' => 'abc']);

        $this->assertSame(['foo' => 'abc', 'bar' => ['baz' => 'def']], $result);
    }

    public function testNestedAlreadySet(): void
    {
        $put = new Put('foo.baz', 'def');

        $result = $put(['foo' => ['bar' => 'abc']]);

        $this->assertSame(['foo' => ['bar' => 'abc', 'baz' => 'def']], $result);
    }

    public function testExpression(): void
    {
        $put = new Put('baz', new Pick('foo.bar'));

        $result = $put(['foo' => ['bar' => 'abc']]);

        $this->assertSame(['foo' => ['bar' => 'abc'], 'baz' => 'abc'], $result);
    }

    public function testValueIsNotSetWhenConstraintFails(): void
    {
        $put = new Put('bar', 'def', new IsEmpty());

        $result = $put(['foo' => 'abc']);

        $this->assertSame(['foo' => 'abc'], $result);
    }
}
