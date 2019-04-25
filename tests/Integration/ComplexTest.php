<?php

declare(strict_types=1);

namespace MapperTests\Integration;

use Mapper\Constraint\IsArrayIndexNotEmpty;
use Mapper\Mapper;
use Mapper\Modifier\Put;
use Mapper\Modifier\Remove;
use Mapper\Value\Collection;
use Mapper\Value\Join;
use Mapper\Value\Left;
use Mapper\Value\Pick;
use Mapper\Value\Right;
use PHPUnit\Framework\TestCase;

final class ComplexTest extends TestCase
{
    public function testComplex(): void
    {
        $data = [
            'contact_id' => 123,
            'contact_name' => 'abc',
            'unloading_point_code' => 234,
            'unloading_point_description' => 'def',
            'invalid_id' => '',
            'invalid_value' => 'hello',
            'valid_id' => 'foo',
            'valid_value' => '',
            'creation_date_date' => '2019-01-01 00:00:00.000',
            'creation_date_time' => '1700-01-01 10:11:12.000',
        ];

        $mapper = new Mapper(
            new Put(
                'contact',
                new Collection([
                    'id' => new Pick('contact_id'),
                    'name' => new Pick('contact_name'),
                ])
            ),
            new Put(
                'unloading_point',
                new Collection([
                    'code' => new Pick('unloading_point_code'),
                    'description' => new Pick('unloading_point_description'),
                ])
            ),
            new Put(
                'invalid',
                new Collection([
                    'id' => new Pick('invalid_id'),
                    'value' => new Pick('invalid_value'),
                ]),
                new IsArrayIndexNotEmpty('id'),
            ),
            new Put(
                'valid',
                new Collection([
                    'id' => new Pick('valid_id'),
                    'value' => new Pick('valid_value'),
                ]),
                new IsArrayIndexNotEmpty('id'),
            ),
            new Put(
                'nested.first',
                new Collection([
                    'a' => 'foo',
                    'b' => 123,
                ])
            ),
            new Put(
                'nested.second',
                new Collection([
                    'a' => 'bar',
                    'b' => 234,
                ])
            ),
            new Put(
                'nested.second',
                new Collection([
                    'c' => 'baz',
                    'd' => 345,
                ])
            ),
            new Put(
                'creation_date',
                new Join(
                    ' ',
                    [
                        new Left(10, new Pick('creation_date_date')),
                        new Right(12, new Pick('creation_date_time')),
                    ]
                )
            ),
            new Put('null', null),
            new Put('string', 'foo'),
            new Put('int', 123),
            new Put('float', 234.56),
            new Remove(['contact_id', 'contact_name']),
            new Remove(['unloading_point_code', 'unloading_point_description']),
            new Remove(['invalid_id', 'invalid_value']),
            new Remove(['valid_id', 'valid_value']),
            new Remove(['creation_date_date', 'creation_date_time'])
        );

        $result = $mapper($data);

        $this->assertSame([
            'contact' => [
                'id' => 123,
                'name' => 'abc',
            ],
            'unloading_point' => [
                'code' => 234,
                'description' => 'def',
            ],
            'valid' => [
                'id' => 'foo',
                'value' => '',
            ],
            'nested' => [
                'first' => [
                    'a' => 'foo',
                    'b' => 123,
                ],
                'second' => [
                    'c' => 'baz',
                    'd' => 345,
                ],
            ],
            'creation_date' => '2019-01-01 10:11:12.000',
            'null' => null,
            'string' => 'foo',
            'int' => 123,
            'float' => 234.56,
        ], $result);
    }
}
