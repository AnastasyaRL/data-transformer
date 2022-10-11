<?php

namespace Anastasya\DateTransformers;

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

class ToDateIntervalsTransformer
{
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
    public static function transform(string $inputDate): array
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
    private static function formatNumber(int $number): string {
        $stringNumbers = ["", "01","02","03","04","05","06","07","08","09"];

        if(0 < $number && $number < 10 ){
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