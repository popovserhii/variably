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
        $params = $this->getConfig('params');
        $options = $params[0] ?? 0;
        //$options = isset($params[0]) ? $params[0] : 0;

        return json_encode($value, $options);
    }
}