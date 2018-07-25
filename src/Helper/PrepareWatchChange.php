<?php
/**
 * Compare changes in database with received data.
 * Return difference in JSON format.
 *
 * Notice. Use this Prepare only in tandem with Importer
 *
 * @category Popov
 * @package Popov_Variably
 * @author Popov Sergiy <popow.serhii@gmail.com>
 */

namespace Popov\Variably\Helper;

use Popov\Db\Db;
use Popov\Importer\Importer;

class PrepareWatchChange extends HelperAbstract implements PrepareInterface
{
    /**
     * @var Db
     */
    protected $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param $value
     * @return string
     */
    public function prepare($value)
    {
        $variably = $this->getVariably();
        /** @var Importer $importer */
        $importer = $variably->get('importer');
        $fields = $variably->get('fields');

        $preparedFields = $importer->getPreparedFields();
        reset($preparedFields);
        end($preparedFields);
        $table = key($preparedFields);

        $params = $this->getConfig('params');
        $ignore = (array) ($params['ignore'] ?? $params[0]);
        $aggregateField = is_array($ignore) ? $ignore[0] : $ignore;
        //$aggregateField = $params['field'] ?? $params[1];

        // If there is no similar row in databases
        if (!($originRows = $importer->getRealRow($fields, $table))) {
            return json_encode([]);
        }
        $originRow = $originRows[0];

        $aggregated = json_decode($originRow[$aggregateField], true);
        $diff = [];
        foreach ($fields as $field => $value) {
            if (!in_array($field, $ignore) && isset($originRow[$field]) && ($originRow[$field] != $value)) {
                //$diff['operation'][] = sprintf('%s: %s -> %s', $field, $originRow[$field], $value);
                $diff['modification'][$field] = [$originRow[$field], $value];
            }
        }

        if ($diff) {
            $diff['checkedAt'] = date('Y-m-d H:i:s');
            $aggregated[] = $diff;
        }

        return json_encode($aggregated);
        //return $aggregated;
    }
}