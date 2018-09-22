<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_ZfcCore
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Popov\Variably;

use Popov\Variably\Helper\FilterCastDeep;

class Preprocessor
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var Variably
     */
    protected $variably;

    /**
     * @var ConfigHandler
     */
    protected $configHandler;

    /**
     * @var FilterCastDeep
     */
    protected $deeper;

    public function __construct(ConfigHandler $configHandler, array $config = [])
    {
        $this->config = $config;
        $this->variably = $configHandler->getVariably();
        $this->configHandler = $configHandler;
        $this->deeper = new FilterCastDeep();
    }

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getConfigHandler()
    {
        return $this->configHandler;
    }

    public function getVariably()
    {
        return $this->variably;
    }

    public function process($item)
    {
        $items = $this->deeper->cast($item, $isDeep = $this->deeper->isDeep($item));

        foreach ($items as & $item) {
            #$this->getVariably()->set('item', $item);
            foreach ($this->config['fields'] as $name => $params) {
                if (is_array($params)) { // complex variable with __filter & __prepare
                    $params['name'] = $name;
                    $value = $this->processValue($params['value'], $params);
                    $this->correlate($item, $value, $params);
                } elseif ($this->getVariably()->is($params)) {
                    $value = $this->getVariably()->process($params);
                    $this->correlate($item, $value, $name);
                } else {
                    $value = $params;
                    $this->correlate($item, $value, $name);
                }
            };
        }

        return $this->deeper->back($items, $isDeep);
    }

    /**
     * @param $value
     * @param $params
     * @return mixed
     */
    public function processValue($value, $params)
    {
        $values = $this->deeper->cast($value, $isDeep = is_array($value));

        foreach ($values as & $val) {
            $val = $this->getVariably()->is($val)
                ? $this->getVariably()->process($val)
                : $val;
        }

        $values = $this->deeper->back($values, $isDeep);
        $prepared = $this->getConfigHandler()->process($values, $params);

        return $prepared;
    }

    /**
     * Correlate handled value corresponding to its inner structure
     *
     * @param $handledValue
     * @param $params
     * @param $item
     */
    public function correlate(& $item, $handledValue, $params)
    {
        if (is_string($params)) {
            // if field not has any preparations
            $item[$params] = ($handledValue !== null) ? $handledValue : '';
        } elseif (isset($params['name']) && is_array($handledValue)) {
            // if field contains values for different fields of one table
            $item = array_merge($item, $handledValue);
        } elseif (isset($params['name'])) {
            // if field has preparation
            $item[$params['name']] = ($handledValue !== null) ? $handledValue : '';
        } else {
            // if field contains values for multi-dimensional save
            $item = $handledValue;
        }
    }
}


