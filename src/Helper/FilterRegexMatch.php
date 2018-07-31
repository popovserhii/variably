<?php
/**
 * Regular expression filter
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 */
namespace Popov\Variably\Helper;

class FilterRegexMatch extends HelperAbstract implements FilterInterface
{
	/**
	 * @param $value
	 * @return array
	 */
	public function filter($value)
	{
        $params = $this->getConfig('params');
        $pattern = $params['pattern'] ?? $params[0];

        preg_match($pattern, $value, $matches);

		return array_slice($matches, 1);
	}
}
