<?php

use Anastasya\DateTransformers\ToDateIntervalsTransformer;
use Anastasya\DateTransformers\ToStringDateTransformer;

require './vendor/autoload.php';

var_dump(ToDateIntervalsTransformer::transform('2 Января 1964 Г'));
var_dump(ToDateIntervalsTransformer::transform('2 Января 1964 Г - 2 июля 1964 Г'));
var_dump(ToDateIntervalsTransformer::transform('2 Января 1964 Г.'));
var_dump(ToDateIntervalsTransformer::transform('1987-12-15'));
var_dump(ToDateIntervalsTransformer::transform('18.07.1990'));
var_dump(ToDateIntervalsTransformer::transform('1954'));
var_dump(ToDateIntervalsTransformer::transform('1961 г'));
var_dump(ToDateIntervalsTransformer::transform('15 February 1983'));
var_dump(ToDateIntervalsTransformer::transform('2 января 1964 г'));
var_dump(ToDateIntervalsTransformer::transform('07.01.1985/28.08.1983'));
var_dump(ToDateIntervalsTransformer::transform('01.05.1995, 01.01.1996,  21.03.1996'));
var_dump(ToDateIntervalsTransformer::transform('1987-1989'));
var_dump(ToDateIntervalsTransformer::transform('22 Sep. 1978'));
var_dump(ToDateIntervalsTransformer::transform('Aug. 1977-Sep. 1977'));