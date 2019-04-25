<?php

declare(strict_types=1);

namespace MapperTests\Constraint;

use Mapper\Constraint\IsEmpty;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mapper\Constraint\IsEmpty
 */
final class IsEmptyTest extends TestCase
{
    public function testSimple(): void
    {
        $is = new IsEmpty();

        $this->assertFalse($is(['foo' => 'abc'], 'foo'));
        $this->assertFalse($is(['foo' => 'abc'], ['foo']));
        $this->assertTrue($is(['foo' => 'abc'], ''));
        $this->assertTrue($is(['foo' => 'abc'], 0));
        $this->assertTrue($is(['foo' => 'abc'], null));
        $this->assertTrue($is(['foo' => 'abc'], []));
    }
}
