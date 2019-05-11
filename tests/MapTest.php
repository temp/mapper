<?php

declare(strict_types=1);

namespace MapperTests;

use PHPUnit\Framework\TestCase;
use function Mapper\map;

/**
 * @covers \Mapper\Map
 */
final class MapTest extends TestCase
{
    public function testWithNullSource(): void
    {
        $result = map(function($i) {return $i;}, ['abc' => 'def']);

        $this->assertSame(['abc' => 'def'], $result);
    }
}
