<?php
/**
 * Prepends passed elements to the front of the array
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;


class FilterUnshift extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        if (is_scalar($value)) {
            $elements = (array) $this->getConfig('params');
            $value = (array) $value;

            array_unshift($value, ...$elements);
        }
        return $value;
    }
}