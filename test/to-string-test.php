<?php

use Anastasya\DateTransformers\DateTransformer;

require './vendor/autoload.php';

echo DateTransformer::transformToString('22 Sep. 1978') . "\n";
echo DateTransformer::transformToString('1987-12-15') . "\n";
echo DateTransformer::transformToString('18.07.1990') . "\n";
echo DateTransformer::transformToString('15 February 1983') . "\n";
echo DateTransformer::transformToString('2 января 1964 г') . "\n";
echo DateTransformer::transformToString('2 Января 1964 Г') . "\n";
echo DateTransformer::transformToString('2 Января 1964 Г - 2 июля 1964 Г') . "\n";
echo DateTransformer::transformToString('2 Января 1964 Г.') . "\n";
echo DateTransformer::transformToString('22 Feb 1978') . "\n";