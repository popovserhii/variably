<?php
/**
 * Merge array
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

class FilterMerge extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {

        $params = (array) $this->getConfig('params');
        if (is_object($value)) {
            $value = [];
        } elseif (is_string($value) || is_numeric($value)) {
            $value = [$value];
        }
        $merged = call_user_func('array_merge', $value, ...$params);

        return $merged;
    }
}