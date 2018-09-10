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
 * Delete all non number symbols from value
 */
class FilterNumber implements FilterInterface {

	/**
	 * @param $num
	 * @return int
	 */
	public function filter($num) 
	{
		return preg_replace('/[^\d]/', '', $num);
	}
}
