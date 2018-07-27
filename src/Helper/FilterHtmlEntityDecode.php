<?php
/**
 * Html Entities decode
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;


class FilterHtmlEntityDecode extends HelperAbstract implements FilterInterface
{
    /**
     * @see https://stackoverflow.com/a/10328395/1335142
     * @param $value
     * @return string
     */
    public function filter($value)
    {
        return html_entity_decode($value, ENT_COMPAT, 'UTF-8');
    }
}