<?php

declare(strict_types=1);

namespace MapperTests\Value;

use Mapper\Exception\ElementNotFound;
use Mapper\Value\Pick;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Value\Pick
 */
final class PickTest extends TestCase
{
    public function testSimplePick(): void
    {
        $pick = new Pick('foo');

        $result = $pick(['foo' => 'bar']);

        $this->assertSame('bar', $result);
    }

    public function testNestedPick(): void
    {
        $pick = new Pick('foo.bar');

        $result = $pick(['foo' => ['bar' => 'baz']]);

        $this->assertSame('baz', $result);
    }

    public function testElementNotFound(): void
    {
        $this->expectException(ElementNotFound::class);

        $pick = new Pick('invalid');

        $pick(['foo' => 'bar']);
    }
}
