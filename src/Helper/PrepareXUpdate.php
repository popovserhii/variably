<?php
/**
 * Exclude item fields from update in database.
 * Notice. Use this Prepare only in tandem with Importer.
 *
 * By the scene db data simply replace original data.
 *
 * @category Popov
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;

use Popov\Importer\Importer;

class PrepareXUpdate extends HelperAbstract implements PrepareInterface
{
    /**
     * @var array
     */
    protected $fields = [];

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
        $deeper = $this->deeper();
        $variably = $this->getVariably();
        /** @var Importer $importer */
        $importer = $variably->get('importer');
        $this->fields = $deeper->cast($variably->get('fields'), $isDeep = $deeper->isDeep($value));

        if ($importer && ($realRows = $importer->getCurrentRealRows())) {
            $excluded = $this->getExcludedFields();
            foreach ($realRows as $key => $realRow) {
                foreach ($excluded as $field) {
                    $this->fields[$key][$field] = $realRow[$field];
                }
            }
            $value = $deeper->back($this->fields, $isDeep);
        }

        return $value;
    }

    protected function getImporter()
    {
        $variably = $this->getVariably();
        /** @var Importer $importer */
        $importer = $variably->get('importer');

        return $importer;
    }

    /**
     * @return FilterCastDeep
     */
    protected function deeper()
    {
        static $cast = null;
        if (!$cast) {
            $cast = new FilterCastDeep();
        }

        return $cast;
    }
    
    protected function getExcludedFields()
    {
        $params = $this->getConfig('params');
        $excluded = (array) $params['exclude'];

        if (!$excluded) {
            $importer = $this->getImporter();
            // If do not pass any fields, all fields will be ignored except id
            $fields = current($this->fields);
            unset($fields['id']);
            $excluded = array_keys($fields);

            if ($preprocessor = $importer->getCurrentFieldsMap('__preprocessor')) {
                $fields = $preprocessor['fields'];
                unset($fields['*']);
                $excluded = array_merge($excluded, array_keys($fields));
                #$excluded += array_keys($fields);
            }
        }

        return $excluded;
    }
}