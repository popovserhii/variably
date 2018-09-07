<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 07.09.2018
 * Time: 12:03
 */

namespace Popov\Variably\Helper;


class FilterMultiExplode extends HelperAbstract implements FilterInterface
{
    public function filter($value)
    {
        $delimiters = $this->getConfig('params') ?? ' ';
        if (!$value) {
            $value = [];
        } else if (is_string($value)) {
            $makeReady = str_replace($delimiters, $delimiters[0], $value);
            $value = explode($delimiters[0], $makeReady);
        } else if (is_array($value)) {
            $value = array_map(function ($value) {
                return $this->filter($value);
            }, $value);
        }

        return $value;
    }
}