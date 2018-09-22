<?php
/**
 * Casts value as an array if it's not one.
 *
 * Flat array casts to multidimensional.
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;

class FilterCastDeep extends HelperAbstract implements FilterInterface
{
    /**
     * @var array
     */
    protected $casting = [];

    /**
     * @param $value
     * @return array
     */
    public function filter($value)
    {
        return $this->cast($value, $this->isDeep($value));
    }

    /**
     * You must use this in strong order of cast() and back() method otherwise get unexpected behavior.
     *
     * Trick: Use new FilterCast instance for each new values for avoid unexpected behavior.
     *
     * @param array $value
     * @param bool $isDeep
     * @return array
     */
    public function cast($value, $isDeep)
    {
        $value = $isDeep ? $value : [$value];

        return $value;
    }

    /**
     * Return $array in original structure
     *
     * @param array $array Multidimensional array
     * @param bool $isDeep Is original value multidimensional array
     * @return array
     */
    public function back($array, $isDeep)
    {
        return $isDeep ? $array : array_shift($array);
    }

    /**
     * Check if array is multidimensional and return first child if it is only one,
     * otherwise return full multidimensional array.
     *
     * @param $array
     * @return array
     */
    public function unwrap($array)
    {
        if ($this->isDeep($array) && count($array) == 1) {
            return array_shift($array);
        }

        return $array;
    }

    /**
     * @param $array
     * @return bool
     */
    public function isDeep($array)
    {
        if (!is_array($array)) {
            return false;
        }
        foreach ($array as $elm) {
            if (is_array($elm)) {
                return true;
            }
        }

        return false;
    }
}