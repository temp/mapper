<?php

include __DIR__.'/../vendor/autoload.php';

use function Mapper\always;
use function Mapper\arr;

$data = [
    'id' => 123,
];

$fn = arr([
    'nested' => arr([
        'first' => arr([
            'a' => always('foo'),
            'b' => always(456),
        ]),
        'second' => arr([
            'a' => always('bar'),
            'b' => always(567),
        ]),
    ]),
]);

echo 'Input:'.PHP_EOL;
print_r($data);

echo 'Output:'.PHP_EOL;
print_r($fn($data));
