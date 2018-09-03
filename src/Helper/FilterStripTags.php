<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 31.08.2018
 * Time: 15:48
 */

namespace Popov\Variably\Helper;


class FilterStripTags extends HelperAbstract implements FilterInterface
{
    public function filter($value)
    {
        $allowed_tags = $this->getConfig('params');
        if ($allowed_tags) {
            strip_tags($value, $allowed_tags);
        }
        return strip_tags($value);
    }
}