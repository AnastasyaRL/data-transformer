<?php

return [
    'patterns' => [
        '($year)-($month)-($day)',
        '($day)\.($month)\.($year)',
        '($day) ($month) ($year)\s?г?\.?',
        '($month) ($year)',
        '($year)\s?г?\.?',
    ],
    'months' => [
        1 => ["01", "января", "January", "Jan\."],
        2 => ["02", "февраля", "February", "Feb\.", "Febr\."],
        3 => ["03", "марта", "March", "Mar\."],
        4 => ["04", "апреля", "April", "Apr\."],
        5 => ["05", "мая", "May",],
        6 => ["06", "июня", "June",],
        7 => ["07", "июля", "July",],
        8 => ["08", "августа", "August", "Aug\."],
        9 => ["09", "сентября", "September", "Sept\.", "Sep\."],
        10 => ["10", "октября", "October", "Oct\."],
        11 => ["11", "ноября", "November", "Nov\."],
        12 => ["12", "декабря", "December", "Dec\."]
    ],
    'interval_separators' => ['-', '/'],
    'interval_initial_words' => [''],
    'collection_separators' => [','],
];