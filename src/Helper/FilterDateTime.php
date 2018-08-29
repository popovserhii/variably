<?php
/**
 * Filter int number
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

use DateTime;

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
        $params = $this->getConfig('params');

        #$locale = $config['locale'];
        $timezone = $config['timezone'] ?? date_default_timezone_get();
        $from = $params['formatFrom'] ?? false;
        $to = $params['formatTo'];

        $dt = $from ? DateTime::createFromFormat($from, $value, $timezone) : new DateTime($value, $timezone);

        return $dt->format($to);
    }
}
