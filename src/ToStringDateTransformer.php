<?php

namespace Anastasya\DateTransformers;

use DateTime;
use Exception;

class ToStringDateTransformer
{
    /**
     * Преобразовать дату в заданный формат
     *
     * @param string $date
     * @param string|null $outputDateFormat
     * @return string
     * @throws Exception
     */
    public static function transform(string $date, ?string $outputDateFormat = 'd.m.Y'): string {
        $rawDate = preg_replace('/\s{2,}/', ' ',  trim($date));
        /**
         * Конвертируем даты типа: "22 Sep. 1978", "1987-12-15", "18.07.1990", "15 February 1983"
         */
        if (DateTime::createFromFormat('Y-m-d', $rawDate) ||
            DateTime::createFromFormat('d.m.Y', $rawDate) ||
            DateTime::createFromFormat('d F Y', $rawDate) ||
            DateTime::createFromFormat('d M. Y', $rawDate)) {
            return (new DateTime($rawDate))->format($outputDateFormat);
        }

        /**
         * Конвертируем дату типа: "2 января 1964 г"
         */
        $months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля",
            "августа", "сентября", "октября", "ноября", "декабря"];
        $monthRegExpression = implode("|", $months);

        $rawWithoutSpaces = str_replace(' ', '', $rawDate);
        $pattern = '/^([0-9]{1,2})(' . $monthRegExpression . ')([0-9]{4})(г)?(.)?$/ui';
        if (preg_match_all($pattern, $rawWithoutSpaces, $matches)) {
            $month = $matches[2][0];
            foreach ($months as $number => $value) {
                if (mb_strtolower($month) === $value) {
                    $monthNumber = $number + 1;
                }
            }

            $formattedDate = preg_replace($pattern, '$1.' . $monthNumber . '.$3', $rawWithoutSpaces);
            return (new DateTime($formattedDate))->format($outputDateFormat);
        }

        return $rawDate;
    }
}