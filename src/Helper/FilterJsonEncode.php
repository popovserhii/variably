<?php
/**
 * Encode array to JSON
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

class FilterJsonEncode extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}