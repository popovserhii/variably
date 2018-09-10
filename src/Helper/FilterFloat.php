<?php
/**
 * Filter float number
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */
namespace Popov\Variably\Helper;

class FilterFloat implements FilterInterface {

	/**
	 * @param $num
	 * @return string
	 */
	public function filter($num) {
		$dotPos = strrpos($num, '.');
		$commaPos = strrpos($num, ',');
		$sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
			((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

		if (!$sep) {
			return floatval(preg_replace("/[^0-9]/", '', $num));
		}

		return floatval(
			preg_replace("/[^0-9]/", '', substr($num, 0, $sep)) . '.' .
			preg_replace("/[^0-9]/", '', substr($num, $sep + 1, strlen($num)))
		);
	}

}