<?php
/**
 * Convert Excel serial number to DateTime
 *
 * Excel stores dates as sequential serial numbers so that they can be used in calculations.
 * By default, January 1, 1900, is serial number 1, and January 1, 2008, is serial number 39448
 * because it is 39,448 days after January 1, 1900
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @see https://support.office.com/en-us/article/convert-dates-stored-as-text-to-dates-8df7663e-98e6-4295-96e4-32a67ec0a680
 * @see https://stackoverflow.com/q/11172644/1335142
 */

namespace Popov\Variably\Helper;

use DateTime;
use DateTimeZone;

class FilterDateExcel extends HelperAbstract implements FilterInterface
{
    protected $defaultConfig = [
        'params' => [
            'formatTo' => 'Y-m-d',
        ],
    ];

    /**
     * Copied from @see \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date_int_val)
     *
     * @param $excelTimestamp
     * @return string Formatted date value
     */
    public function filter($excelTimestamp)
    {
        $params = $this->getConfig('params');
        $timezone = $config['timezone'] ?? date_default_timezone_get();
        $to = $params['formatTo'];

        if ($excelTimestamp < 1.0) {
            // Unix timestamp base date
            $dt = new DateTime('1970-01-01', new DateTimeZone($timezone));
        } else {
            // MS Excel calendar base dates
            #if (self::$excelCalendar == self::CALENDAR_WINDOWS_1900) {
            // Allow adjustment for 1900 Leap Year in MS Excel
            $dt = ($excelTimestamp < 60)
                ? new DateTime('1899-12-31', new DateTimeZone($timezone))
                : new DateTime('1899-12-30', new DateTimeZone($timezone));

            #} else {
            #    $baseDate = new \DateTime('1904-01-01', $timezone);
            #}
        }

        $days = floor($excelTimestamp);
        $partDay = $excelTimestamp - $days;
        $hours = floor($partDay * 24);
        $partDay = $partDay * 24 - $hours;
        $minutes = floor($partDay * 60);
        $partDay = $partDay * 60 - $minutes;
        $seconds = round($partDay * 60);
        if ($days >= 0) {
            $days = '+' . $days;
        }
        $interval = $days . ' days';

        return $dt->modify($interval)
            ->setTime($hours, $minutes, $seconds)
            ->format($to);
    }
}
