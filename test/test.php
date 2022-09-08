<?php

use Anastasya\DateTransformers\ToStringDateTransformer;

require './vendor/autoload.php';

echo ToStringDateTransformer::transform('22 Sep. 1978') . "\n";
echo ToStringDateTransformer::transform('1987-12-15') . "\n";
echo ToStringDateTransformer::transform('18.07.1990') . "\n";
echo ToStringDateTransformer::transform('15 February 1983') . "\n";
echo ToStringDateTransformer::transform('2 января 1964 г') . "\n";
echo ToStringDateTransformer::transform('2 Января 1964 Г') . "\n";
echo ToStringDateTransformer::transform('2 Января 1964 Г - 2 июля 1964 Г') . "\n";
echo ToStringDateTransformer::transform('2 Января 1964 Г.') . "\n";