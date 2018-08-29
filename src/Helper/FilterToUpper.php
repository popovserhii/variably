<?php
/**
 * String to upper case
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;


class FilterToUpper extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        return mb_strtoupper($value);
    }
}