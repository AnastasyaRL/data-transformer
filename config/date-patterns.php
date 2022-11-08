<?php

return [
    'patterns' => [
        '($year)-($month)-($day)',
        '($day)\.($month)\.($year)',
        '($month)\.($year)',
        '($day)\.($month)',
        '($day)\/($month)\/($year)',
        '($day) ($month) ($year)\s?г?\.?',
        '($month) ($year)',
        '($year)\s?г?\.?',
        '($year)\s?\(($month)\)',
    ],
    'months' => [
        1 => ["1", "01", "января", "January", "Jan\.?"],
        2 => ["2", "02", "февраля", "February", "Febr?\.?"],
        3 => ["3", "03", "марта", "March", "Mar\.?"],
        4 => ["4", "04", "апреля", "April", "Apr\.?"],
        5 => ["5", "05", "мая", "May",],
        6 => ["6", "06", "июня", "June", "Jun\.?"],
        7 => ["7", "07", "июля", "July", "Jul\.?"],
        8 => ["8", "08", "августа", "August", "Aug\.?"],
        9 => ["9", "09", "сентября", "September", "Sept\.?", "Sep\.?"],
        10 => ["10", "октября", "October", "Oct\.?"],
        11 => ["11", "ноября", "November", "Nov\.?"],
        12 => ["12", "декабря", "December", "Dec\.?"]
    ],
    'interval_separators' => ['-', '/'],
    'interval_initial_words' => [''],
    'collection_separators' => [','],
];