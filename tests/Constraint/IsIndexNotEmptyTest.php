<?php

declare(strict_types=1);

namespace MapperTests\Constraint;

use Mapper\Constraint\IsArrayIndexNotEmpty;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Constraint\IsArrayIndexNotEmpty
 */
final class IsIndexNotEmptyTest extends TestCase
{
    public function testSimple(): void
    {
        $is = new IsArrayIndexNotEmpty('foo');

        $this->assertFalse($is(['foo' => 'abc'], 'foo'));
        $this->assertFalse($is(['foo' => 'abc'], ['foo' => '']));
        $this->assertFalse($is(['foo' => 'abc'], ['foo' => 0]));
        $this->assertFalse($is(['foo' => 'abc'], ['foo' => null]));
        $this->assertTrue($is(['foo' => 'abc'], ['foo' => 'bar']));
    }
}
