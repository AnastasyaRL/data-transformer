<?php

namespace Anastasya\DateTransformers;

use DateTime;
use Exception;
use Ruslanovich\DateConverter\Enums\RowTypeEnum;
use Ruslanovich\DateConverter\Exceptions\ConvertToDateCollectionException;
use Ruslanovich\DateConverter\Exceptions\ConvertToDateException;
use Ruslanovich\DateConverter\Exceptions\ConvertToDateIntervalException;
use Ruslanovich\DateConverter\Exceptions\InvalidCollectionException;
use Ruslanovich\DateConverter\Exceptions\InvalidIntervalException;
use Ruslanovich\DateConverter\Exceptions\InvalidPatternResourceException;
use Ruslanovich\DateConverter\Models\DateModel;
use Ruslanovich\DateConverter\Services\RowToModelConverter;
use Ruslanovich\DateConverter\Storages\PatternStorages\ArrayPatternStorage;

class DateTransformer
{
    /**
     * @param string $date
     * @param string|null $outputDateFormat
     * @return string
     * @throws Exception
     */
    public static function transformToString(string $date, ?string $outputDateFormat = 'd.m.Y'): string
    {
        $rawDate = preg_replace('/\s{2,}/', ' ', trim($date));
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

    /**
     * @param string $inputDate
     * @return array
     * @throws ConvertToDateCollectionException
     * @throws ConvertToDateException
     * @throws ConvertToDateIntervalException
     * @throws InvalidCollectionException
     * @throws InvalidIntervalException
     * @throws InvalidPatternResourceException
     */
    public static function transformToIntervals(string $inputDate): array
    {
        $config = require __DIR__ . '/../config/date-patterns.php';
        $patternStorage = new ArrayPatternStorage($config);
        $converter = new RowToModelConverter($patternStorage);
        $dateType = $converter->getRowType($inputDate)->getType();

        switch ($dateType) {
            case RowTypeEnum::SIMPLE_DATE:
                $date = $converter->convertToDate($inputDate);
                return [
                    self::formatDate($date)
                ];
            case RowTypeEnum::DATE_INTERVAL:
                $interval = $converter->convertToInterval($inputDate);
                return [
                    [
                        'from' => self::formatDate($interval->getInitialDate())['from'],
                        'till' => self::formatDate($interval->getFinalDate())['till']
                    ]
                ];

            case RowTypeEnum::DATE_COLLECTION:
                $dateIntervals = [];
                $collection = $converter->convertToDateCollection($inputDate);
                foreach ($collection->getAll() as $dateModel) {
                    $dateIntervals[] = self::formatDate($dateModel);
                }

                return $dateIntervals;
            default:
                return [];
        }
    }

    /**
     * @param DateModel $date
     * @return string[]
     */
    private static function formatDate(DateModel $date): array
    {
        if (!$date->getMonthNumber()) {
            return [
                'from' => '01.01.' . $date->getYear(),
                'till' => '31.12.' . $date->getYear(),
            ];
        }

        $formattedMonth = self::formatNumber($date->getMonthNumber()->getMonthNumber());
        if (!$date->getDay()) {
            return [
                'from' => '01.' . $formattedMonth . '.' . $date->getYear(),
                'till' => self::getCountDaysInMonth($date->getMonthNumber()->getMonthNumber(), $date->getYear()) .
                    '.' . $formattedMonth . '.' . $date->getYear(),
            ];
        }

        return [
            'from' => self::formatNumber($date->getDay()) . '.' . $formattedMonth . '.' . $date->getYear(),
            'till' => self::formatNumber($date->getDay()) . '.' . $formattedMonth . '.' . $date->getYear()
        ];
    }

    /**
     * @param int $number
     * @return string
     */
    private static function formatNumber(int $number): string
    {
        $stringNumbers = ["", "01", "02", "03", "04", "05", "06", "07", "08", "09"];

        if (0 < $number && $number < 10) {
            return $stringNumbers[$number];
        }

        return (string)$number;
    }

    /**
     * @param int $month
     * @param int $year
     * @return int
     */
    private static function getCountDaysInMonth(int $month, int $year): int
    {
        $countFebDays = self::isLearYear($year) ? 29 : 28;
        $monthDays = [31, $countFebDays, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        return $monthDays[$month - 1];
    }

    /**
     * @param int $year
     * @return bool
     */
    private static function isLearYear(int $year): bool
    {
        if ($year % 400 == 0)
            return true;
        else if ($year % 100 == 0)
            return false;
        else if ($year % 4 == 0)
            return true;
        else
            return false;
    }
}