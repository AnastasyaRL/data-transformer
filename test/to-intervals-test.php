<?php

use Anastasya\DateTransformers\DateTransformer;
use Anastasya\DateTransformers\ToStringDateTransformer;

require './vendor/autoload.php';

var_dump(DateTransformer::transformToIntervals('2 Января 1964 Г'));
var_dump(DateTransformer::transformToIntervals('2 Января 1964 Г - 2 июля 1964 Г'));
var_dump(DateTransformer::transformToIntervals('2 Января 1964 Г.'));
var_dump(DateTransformer::transformToIntervals('1987-12-15'));
var_dump(DateTransformer::transformToIntervals('18.07.1990'));
var_dump(DateTransformer::transformToIntervals('1954'));
var_dump(DateTransformer::transformToIntervals('1961 г'));
var_dump(DateTransformer::transformToIntervals('15 February 1983'));
var_dump(DateTransformer::transformToIntervals('2 января 1964 г'));
var_dump(DateTransformer::transformToIntervals('07.01.1985/28.08.1983'));
var_dump(DateTransformer::transformToIntervals('01.05.1995, 01.01.1996,  21.03.1996'));
var_dump(DateTransformer::transformToIntervals('1987-1989'));
var_dump(DateTransformer::transformToIntervals('22 Sep. 1978'));
var_dump(DateTransformer::transformToIntervals('Aug. 1977-Sep. 1977'));
var_dump(DateTransformer::transformToIntervals('22 Feb 1978'));
var_dump(DateTransformer::transformToIntervals('10.1978'));
var_dump(DateTransformer::transformToIntervals('28.01'));
var_dump(DateTransformer::transformToIntervals('12/11/1999'));
var_dump(DateTransformer::transformToIntervals('26 Jun. 1978'));
var_dump(DateTransformer::transformToIntervals('1958 (Sep.)'));
