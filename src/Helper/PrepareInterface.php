<?php
/**
 * Prepare Interface
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 13.05.2016 13:38
 */
namespace Popov\Variably\Helper;

interface PrepareInterface
{
    /**
     * Prepare value
     *
     * @param $value
     * @return mixed
     */
    public function prepare($value);
}
