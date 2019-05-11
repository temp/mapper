<?php

include __DIR__.'/../vendor/autoload.php';

use function Mapper\always;
use function Mapper\arr;

$data = [
    'id' => 123,
];

$fn = arr([
    'null' => always(null),
    'string' => always('foo'),
    'int' => always(789),
    'float' => always(890.12),
]);

echo 'Input:'.PHP_EOL;
print_r($data);

echo 'Output:'.PHP_EOL;
print_r($fn($data));
