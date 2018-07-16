<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_<package>
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 10.04.2017 14:00
 */
namespace PopovTest\Importer\Adapter;

use PHPUnit\Framework\TestCase as TestCase;
use Popov\Variably\Helper\FilterDate;

class FilterDateTest extends TestCase
{
    /**
     * @param $format
     * @param $date
     * @param $expected
     *
     * @dataProvider datesProvider
     */
    public function testConvertDateFromDifferentLocales($format, $date, $expected)
    {
        $filter = new FilterDate();

        // echo date('l jS \of F Y h:i:s A');
        //$filter->setStashConfig(['params' => ['format_from' => 'F d, Y']]);
        $filter->setStashConfig(['params' => ['format_from' => $format]]);

        // es - 20 de enero de 2018
        // fr - 2 février 2018
        // com - May 16, 2016
        // de - 27 June 2018
        $date = $filter->filter($date);
        //$date = $filter->filter('April 17, 1790');



        $this->assertEquals(
            $expected,
            $date
        );
    }



    public static function datesProvider()
    {
        return [
            ['d F Y', '20 de enero de 2018', '2018-01-20'],
            #['d F Y', '2 février 2018', '2018-02-2'],
            #['F d, Y', 'May 16, 2016', '2016-05-16'],
            #['d F Y', '27 June 2018', '2018-06-27'],
        ];
    }
}