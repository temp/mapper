<?php

declare(strict_types=1);

namespace MapperTests;

use Mapper\Expression;
use Mapper\Mapper;
use Mapper\Value\Pick;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Mapper
 */
final class MapperTest extends TestCase
{
    public function testWithoutExpressions(): void
    {
        $mapper = new Mapper();

        $result = $mapper(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $result);
    }

    public function testCall(): void
    {
        $expression = $this->prophesize(Expression::class);
        $expression->__invoke(['foo' => 'bar'])
            ->willReturn('test');

        $mapper = new Mapper($expression->reveal());

        $result = $mapper(['foo' => 'bar']);

        $this->assertSame('test', $result);
    }

    public function testWithSingleExpression(): void
    {
        $mapper = new Mapper(new Pick('foo'));

        $result = $mapper(['foo' => 'bar']);

        $this->assertSame('bar', $result);
    }
}
