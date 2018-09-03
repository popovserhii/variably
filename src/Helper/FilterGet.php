<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 30.08.2018
 * Time: 11:32
 */

namespace Popov\Variably\Helper;


class FilterGet extends HelperAbstract implements FilterInterface
{
    public function filter($value)
    {
        $params = $this->getConfig('params');
        $index = $params[0];
        return $value[$index];
    }
}