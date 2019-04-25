<?php

declare(strict_types=1);

namespace MapperTests\Constraint;

use Mapper\Constraint\IsArrayIndexEmpty;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Constraint\IsArrayIndexEmpty
 */
final class IsIndexEmptyTest extends TestCase
{
    public function testSimple(): void
    {
        $is = new IsArrayIndexEmpty('foo');

        $this->assertTrue($is(['foo' => 'abc'], 'foo'));
        $this->assertTrue($is(['foo' => 'abc'], ['foo' => '']));
        $this->assertTrue($is(['foo' => 'abc'], ['foo' => 0]));
        $this->assertTrue($is(['foo' => 'abc'], ['foo' => null]));
        $this->assertFalse($is(['foo' => 'abc'], ['foo' => 'bar']));
    }
}
