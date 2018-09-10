<?php
/**
 * Filter int number
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

use DateTime;
use DateTimeZone;

/**
 * Convert date to standard format
 */
class FilterDateTime extends HelperAbstract implements FilterInterface
{

    protected $defaultConfig = [
        'params' => [
            //'formatFrom' => 'Y-m-d',
            'formatTo' => 'Y-m-d H:i:s',
        ],
    ];

    public function filter($value)
    {
        if (!$value) {
            // Unix timestamp base date
            $value = '1970-01-01';
        }

        $params = $this->getConfig('params');

        #$locale = $config['locale'];
        $timezone = $config['timezone'] ?? date_default_timezone_get();
        $from = $params['formatFrom'] ?? false;
        $to = $params['formatTo'];

        $dt = $from
            ? DateTime::createFromFormat($from, $value, new DateTimeZone($timezone))
            : new DateTime($value, new DateTimeZone($timezone));

        return $dt->format($to);
    }
}
