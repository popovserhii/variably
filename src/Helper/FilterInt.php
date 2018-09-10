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

/**
 * Convert any numeric string to integer value.
 * Method is very general and is not optimized.
 * For custom value better create personal filter.
 *
 * @link http://php.net/manual/en/function.intval.php#111582
 */
class FilterInt implements FilterInterface
{
    /**
     * @param $num
     * @return int
     */
    public function filter($num)
    {
        return (int) preg_replace('/[^\-\d]*(\-?\d*).*/', '$1', $num);
    }
}
