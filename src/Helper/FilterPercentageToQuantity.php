<?php
/**
 * Convert percentage of total to quantity
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 27.04.2016 20:08
 */

namespace Popov\Variably\Helper;

/**
 * For example:
 *  total: 15
 *  percentage: 20
 *  result: round(15 / 100) * 20)
 */
class FilterPercentageToQuantity extends HelperAbstract implements FilterInterface
{
    public function filter($value)
    {
        $params = $this->getConfig('params');
        $total = $params['total'] ?? $params[0];

        $percent = (int) trim($value, '%') / 100;

        $correlated = round($percent * $total);

        return $correlated;
    }
}