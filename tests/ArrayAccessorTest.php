<?php

declare(strict_types=1);

namespace MapperTests;

use Mapper\ArrayAccessor;
use Mapper\Exception\ElementNotFound;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\ArrayAccessor
 */
final class ArrayAccessorTest extends TestCase
{
    public function testHas(): void
    {
        $accessor = new ArrayAccessor();

        $data = [
            'string' => 'foo',
            'int' => 123,
            'float' => 234.5,
            'true' => true,
            'false' => false,
            'null' => null,
            'array' => [1, 2, 3],
            'more' => ['complex' => ['structure' => 'bar']],
        ];

        $this->assertTrue($accessor->has($data, 'string'));
        $this->assertTrue($accessor->has($data, 'int'));
        $this->assertTrue($accessor->has($data, 'float'));
        $this->assertTrue($accessor->has($data, 'true'));
        $this->assertTrue($accessor->has($data, 'false'));
        $this->assertTrue($accessor->has($data, 'null'));
        $this->assertTrue($accessor->has($data, 'array'));
        $this->assertTrue($accessor->has($data, 'more.complex'));
        $this->assertTrue($accessor->has($data, 'more.complex.structure'));
        $this->assertFalse($accessor->has($data, 'invalid'));
        $this->assertFalse($accessor->has($data, 'invalid.element'));
    }

    public function testGet(): void
    {
        $accessor = new ArrayAccessor();

        $data = [
            'string' => 'foo',
            'int' => 123,
            'float' => 234.5,
            'true' => true,
            'false' => false,
            'null' => null,
            'array' => [1, 2, 3],
            'more' => ['complex' => ['structure' => 'bar']],
        ];

        $this->assertSame('foo', $accessor->get($data, 'string'));
        $this->assertSame(123, $accessor->get($data, 'int'));
        $this->assertSame(234.5, $accessor->get($data, 'float'));
        $this->assertTrue($accessor->get($data, 'true'));
        $this->assertFalse($accessor->get($data, 'false'));
        $this->assertNull($accessor->get($data, 'null'));
        $this->assertsame([1, 2, 3], $accessor->get($data, 'array'));
        $this->assertsame(['structure' => 'bar'], $accessor->get($data, 'more.complex'));
        $this->assertsame('bar', $accessor->get($data, 'more.complex.structure'));
    }

    public function testGetThrowsElementNotFound(): void
    {
        $this->expectException(ElementNotFound::class);

        $accessor = new ArrayAccessor();

        $data = [
            'string' => 'foo',
        ];

        $accessor->get($data, 'int');
    }

    public function testSet(): void
    {
        $accessor = new ArrayAccessor();

        $data = [];
        $accessor->set($data, 'string', 'foo');
        $accessor->set($data, 'int', 123);
        $accessor->set($data, 'float', 234.5);
        $accessor->set($data, 'true', true);
        $accessor->set($data, 'false', false);
        $accessor->set($data, 'null', null);
        $accessor->set($data, 'array', [1, 2, 3]);
        $accessor->set($data, 'more.complex.structure', 'bar');
        $accessor->set($data, 'nested.one', 'foo');
        $accessor->set($data, 'nested.two', 'bar');
        $accessor->set($data, 'nested.three', [1, 2]);
        $accessor->set($data, 'nested.three', [3, 4]);

        $this->assertSame(
            [
                'string' => 'foo',
                'int' => 123,
                'float' => 234.5,
                'true' => true,
                'false' => false,
                'null' => null,
                'array' => [1, 2, 3],
                'more' => ['complex' => ['structure' => 'bar']],
                'nested' => ['one' => 'foo', 'two' => 'bar', 'three' => [3, 4]],
            ],
            $data
        );
    }

    public function testRemove(): void
    {
        $accessor = new ArrayAccessor();

        $data = [
            'string' => 'foo',
            'int' => 123,
            'float' => 234.5,
            'true' => true,
            'false' => false,
            'null' => null,
            'array' => [1, 2, 3],
            'more' => ['complex' => ['structure' => 'bar']],
            'nested' => ['one' => 'foo', 'two' => 'bar', 'three' => [3, 4]],
        ];

        $accessor->remove($data, 'int');
        $accessor->remove($data, 'array');
        $accessor->remove($data, 'nested.two');

        $this->assertSame(
            [
                'string' => 'foo',
                'float' => 234.5,
                'true' => true,
                'false' => false,
                'null' => null,
                'more' => ['complex' => ['structure' => 'bar']],
                'nested' => ['one' => 'foo', 'three' => [3, 4]],
            ],
            $data
        );
    }

    public function testRemoveThrowsElementNotFound(): void
    {
        $this->expectException(ElementNotFound::class);

        $accessor = new ArrayAccessor();

        $data = [
            'string' => 'foo',
        ];

        $accessor->remove($data, 'int');
    }

    public function testRemoveThrowsElementNotFoundOnNestedElements(): void
    {
        $this->expectException(ElementNotFound::class);

        $accessor = new ArrayAccessor();

        $data = [
            'string' => 'foo',
        ];

        $accessor->remove($data, 'one.two');
    }
}
