<?php
/**
 * Force value to array
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;


class FilterToArray extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return array|mixed
     */
    public function filter($value)
    {
        return (array) $value;
    }
}