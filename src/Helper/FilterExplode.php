<?php
/**
 * Explode string by delimeter
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

class FilterExplode extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        $mark = $this->getConfig('params')[0] ?? ' ';
        if (!$value) {
            $value = [];
        } else if (is_string($value)) {
            $value = explode($mark, $value);
        } else if (is_array($value)) {
            $value = array_map(function ($value) {
                return $this->filter($value);
            }, $value);
        }

        return $value;
    }
}