<?php
/**
 * To decode an entity into a character, html_entity_decode needs to know what encoding you'd like your character to be in.
 * "ü" can be represented in Latin-1, UTF-8, UTF-16 and a host of other encodings.
 * The default is Latin-1. &#8211; (–, EN DASH) cannot be represented in Latin-1. Hence it stays unchanged.
 * Tell html_entity_decode to decode it into an encoding that can represent that character, like UTF-8:
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