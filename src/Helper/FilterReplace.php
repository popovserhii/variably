<?php
/**
 * Replace text in string
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;

class FilterReplace extends HelperAbstract implements FilterInterface
{
    /**
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        $params = $this->getConfig('params');
        $from = $params['from'] ?? $params[0];
        $to = $params['to'] ?? $params[0];

        if (!$value) {
            $value = '';
        } else if (is_string($value)) {
            $value = str_replace($from, $to, $value);
        } else if (is_array($value)) {
            $value = array_map(function ($value) {
                return $this->filter($value);
            }, $value);
        }

        return $value;
    }
}