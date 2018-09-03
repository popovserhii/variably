<?php
/**
 * Trim string
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;

class FilterTrim extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        $params = $this->getConfig('params');
        $charList = $params['charList'] ?? $params[0] ?? " \t\n\r\0\x0B";

        if (!$value) {
            $value = '';
        } else if (is_string($value)) {
            $value = trim($value, $charList);
        } else if (is_array($value)) {
            $value = array_map(function ($value) {
                return $this->filter($value);
            }, $value);
        }

        return $value;
    }
}