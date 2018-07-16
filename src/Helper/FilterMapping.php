<?php
/**
 * Map one value to another
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

class FilterMapping extends HelperAbstract implements FilterInterface
{
    public function filter($value)
    {
        $config = $this->getConfig();
        $mapped = null;
        if (isset($config['map'][$value])) {
            $mapped = $config['map'][$value];
        } else {
            $mapped = $config['map']['__default'];
        }

        return $mapped;
    }
}