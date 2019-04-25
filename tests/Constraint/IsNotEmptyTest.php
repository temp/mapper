<?php

declare(strict_types=1);

namespace MapperTests\Constraint;

use Mapper\Constraint\IsNotEmpty;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Constraint\IsNotEmpty
 */
final class IsNotEmptyTest extends TestCase
{
    public function testSimple(): void
    {
        $is = new IsNotEmpty();

        $this->assertTrue($is(['foo' => 'abc'], 'foo'));
        $this->assertTrue($is(['foo' => 'abc'], ['foo']));
        $this->assertFalse($is(['foo' => 'abc'], ''));
        $this->assertFalse($is(['foo' => 'abc'], 0));
        $this->assertFalse($is(['foo' => 'abc'], null));
        $this->assertFalse($is(['foo' => 'abc'], []));
    }
}
