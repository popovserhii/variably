<?php
/**
 * Convert string to date
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

/**
 * Format date is taken from @see http://php.net/manual/en/function.date.php
 */
class FilterDateNative extends HelperAbstract implements FilterInterface
{
    protected $defaultConfig = [
        'params' => [
            //'format_from' => '',
            'formatTo' => 'Y-m-d',
        ],
    ];

    public function filter($value)
    {
        $config = $this->getConfig();

        $locale = $config['params']['locale'];
        $timezone = $config['params']['timezone'] ?? date_default_timezone_get();
        $to = $config['params']['formatTo'];

        $df = \IntlDateFormatter::create(
            $locale
            , \IntlDateFormatter::MEDIUM
            , \IntlDateFormatter::NONE
            , $timezone
        );

        $timestamp = $df->parse($value);
        $dt = (new \DateTime())->setTimestamp($timestamp);

        return $dt->format($to);
    }
}