<?php
/**
 *  String concatenation
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

class FilterConcat extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        $params = $this->getConfig('params');

        return $value . implode('', $params);
    }
}