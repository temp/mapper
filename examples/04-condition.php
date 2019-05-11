<?php

include __DIR__.'/../vendor/autoload.php';

use function Mapper\arr;
use function Mapper\compose;
use function Mapper\ifElse;
use function Mapper\isEmpty;
use function Mapper\prop;

$data = [
    'invalid_id' => '',
    'invalid_value' => 'hello',
    'valid_id' => 'foo',
    'valid_value' => 'bar',
];

$fn = arr([
    'invalid' => ifElse(
        compose(isEmpty(), prop('invalid_id')),
        null,
        arr([
            'id' => prop('invalid_id'),
            'value' => prop('invalid_value'),
        ]),
    ),
    'valid' => ifElse(
        compose(isEmpty(), prop('valid_id')),
        null,
        arr([
            'id' => prop('valid_id'),
            'value' => prop('valid_value'),
        ]),
    ),
]);

echo 'Input:'.PHP_EOL;
print_r($data);

echo 'Output:'.PHP_EOL;
print_r($fn($data));
