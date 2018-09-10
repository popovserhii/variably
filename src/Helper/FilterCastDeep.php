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
        return $this->cast($value);
    }

    /**
     * You must use this in strong order of cast() and back() method otherwise get unexpected behavior.
     *
     * Trick: Use new FilterCast instance for each new values for avoid unexpected behavior.
     *
     * @param $value
     * @return array
     */
    public function cast($value)
    {
        $isDeep = $this->isDeep($value);
        $this->casting[] = $isDeep;
        $value = $isDeep ? $value : [$value];

        return $value;
    }

    /**
     * @param $array
     * @return array
     */
    public function back($array)
    {
        return array_pop($this->casting) ? $array : array_shift($array);
    }

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