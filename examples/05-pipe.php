<?php

include __DIR__.'/../vendor/autoload.php';

use function Mapper\arr;
use function Mapper\compose;
use function Mapper\pipe;
use function Mapper\prop;
use function Mapper\take;

$data = [
    'abc' => 'def',
    'foo' => 'bar',
];

$fn = arr([
    'abc' => pipe(prop('abc'), take(1)),
    'foo' => compose(take(1), prop('foo')),
]);

echo 'Input:'.PHP_EOL;
print_r($data);

echo 'Output:'.PHP_EOL;
print_r($fn($data));
