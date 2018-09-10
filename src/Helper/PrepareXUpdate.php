<?php
/**
 * Exclude item fields from update in database.
 * Notice. Use this Prepare only in tandem with Importer.
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;

use Popov\Importer\Importer;

class PrepareXUpdate extends HelperAbstract implements PrepareInterface
{
    protected $defaultConfig = [
        'params' => [
            'exclude' => [],
        ],
    ];

    /**
     * @param $value
     * @return array
     */
    public function prepare($value)
    {
        $cast = $this->cast();
        $variably = $this->getVariably();
        /** @var Importer $importer */
        $importer = $variably->get('importer');
        $items = $cast->filter($variably->get('fields'));

        $params = $this->getConfig('params');
        $excluded = (array) $params['exclude'];

        if ($importer && ($realRows = $importer->getCurrentRealRows())) {
            foreach ($realRows as $key => $realRow) {
                if (!$excluded) {
                    // If do not pass any fields, all fields will be ignored except id
                    $excluded = array_keys($items[$key]);
                    unset($excluded[array_search('id', $excluded)]);
                }
                foreach ($excluded as $field) {
                    $items[$key][$field] = $realRow[$field];
                }
            }
            $value = $cast->back($items);
        }

        return $value;
    }

    /**
     * @return FilterCastDeep
     */
    protected function cast()
    {
        static $cast = null;
        if (!$cast) {
            $cast = new FilterCastDeep();
        }

        return $cast;
    }
}