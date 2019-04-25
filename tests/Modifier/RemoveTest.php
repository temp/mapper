<?php

declare(strict_types=1);

namespace MapperTests\Modifier;

use Mapper\Constraint\IsEmpty;
use Mapper\Modifier\Remove;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Modifier\Remove
 */
final class RemoveTest extends TestCase
{
    public function testSimple(): void
    {
        $remove = new Remove('foo');

        $result = $remove(['foo' => 'abc', 'bar' => 'def']);

        $this->assertSame(['bar' => 'def'], $result);
    }

    public function testArray(): void
    {
        $remove = new Remove(['foo', 'bar']);

        $result = $remove(['foo' => 'abc', 'bar' => 'def']);

        $this->assertSame([], $result);
    }

    public function testNested(): void
    {
        $remove = new Remove('foo.bar');

        $result = $remove(['foo' => ['bar' => 'abc', 'baz' => 'def']]);

        $this->assertSame(['foo' => ['baz' => 'def']], $result);
    }

    public function testInvalid(): void
    {
        $remove = new Remove('baz');

        $result = $remove(['foo' => 'abc', 'bar' => 'def']);

        $this->assertSame(['foo' => 'abc', 'bar' => 'def'], $result);
    }

    public function testValueIsNotRemovedWhenConstraintFails(): void
    {
        $remove = new Remove('foo', new IsEmpty());

        $result = $remove(['foo' => 'abc']);

        $this->assertSame(['foo' => 'abc'], $result);
    }
}
