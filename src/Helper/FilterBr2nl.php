<?php
/**
 * Filter int number
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */
namespace Popov\Variably\Helper;

/**
 * Replace <br> tags to new line symbol
 */
class FilterBr2nl implements FilterInterface {

	/**
	 * @param $value
	 * @return int
	 */
	public function filter($value)
	{
        return preg_replace('/<br\s?\/?>/i', "\r\n", $value);
	}
}
