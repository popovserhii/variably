<?php
/**
 * String to lower case
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;


class FilterToLower extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        return mb_strtolower($value);
    }
}