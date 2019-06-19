<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_Variable
 * @author Serhii Popov <popow.serhii@gmail.com>
 */
namespace PopovTest\Variably\Helper;

use PHPUnit\Framework\TestCase as TestCase;
use Popov\Variably\Helper\FilterDateNative;

class FilterDateTest extends TestCase
{
    /**
     * @param $locale
     * @param $date
     * @param $expected
     * @dataProvider datesProvider
     */
    public function testConvertDateFromDifferentLocales($date, $locale, $expected)
    {
        $filter = new FilterDateNative();
        /**
        'locales_map' => [
        'de' => 'de_DE',
        'fr' => 'fr_FR',
        'it' => 'it_IT',
        'co.uk' => 'en_GB',
        'es' => 'es_ES',
        'usa' => 'en_UK',
        ]
         */

        // es - 20 de enero de 2018
        // fr - 2 février 2018
        // com - May 16, 2016
        // de - 27 June 2018
        $filter->setStashConfig(['params' => ['locale' => $locale]]);
        //$filter->setStashConfig(['params' => ['formatTo' => $locale]]);

        $date = $filter->filter($date);

        $this->assertEquals(
            $expected,
            $date
        );
    }

    public static function datesProvider()
    {
        return [
            ['1 aprile 2019', 'it_IT', '2019-04-01'],
            ['24 aprile 2019', 'it_IT', '2019-04-24'],

            ['20 enero 2018', 'es_ES', '2018-01-20'],

            ['2 février 2018', 'fr_FR', '2018-02-02'],

            ['11. Juni 2019', 'de_DE', '2019-06-11'],

            ['27 June 2018', 'en_GB', '2018-06-27'],
        ];
    }
}