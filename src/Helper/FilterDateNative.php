<?php
/**
 * Convert string to date
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
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
            'format_to' => 'Y-m-d',
        ],
    ];

    public function filter($value)
    {
        //$value = 'June 2008';
        //$value = '27 June, 2018';
        $config = $this->getConfig();


        $locale = $config['params']['locale'];
        $timezone = $config['params']['timezone'] ?? date_default_timezone_get();
        $to = $config['params']['format_to'];
        // es - 20 de enero de 2018
        // fr - 2 février 2018
        // com - May 16, 2016
        // de - 27. Juni 2018

        #$date = \DateTime::createFromFormat($from, $value/*[, DateTimeZone $timezone ] */);
        /*$date = \DateTime::createFromFormat($from, $value, new \DateTimeZone('Europe/Madrid'));

        $error = \DateTime::getLastErrors();*/


        $df = \IntlDateFormatter::create(
            $locale
            , \IntlDateFormatter::MEDIUM
            , \IntlDateFormatter::NONE
            , $timezone
        );

        //$timestamp = $fmt->parse($value);
        $timestamp = $df->parse($value);


        $dt = (new \DateTime())->setTimestamp($timestamp);
        //$dt->setTimestamp($timestamp);



        
        //$dt = new \DateTime();
        //$dt->setTimestamp($timestamp);


        // I'm in Europe/Moscow (GMT +3)
        /*echo date_default_timezone_get().PHP_EOL;

        $df = \IntlDateFormatter::create(
            'fr_FR',
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            'Europe/Moscow'    // GMT +3
        );

        //$timestamp = $df->parse('Jun 19, 2015');
        $timestampf = $df->parse('2 février 2018');*/


        /*$df = \IntlDateFormatter::create(
            'es_ES',
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            'Europe/Moscow'    // GMT +3
        );*/



        return $dt->format($to);
    }
}