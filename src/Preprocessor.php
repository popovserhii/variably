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

    protected $cast = [];

    public function __construct(ConfigHandler $configHandler, array $config = [])
    {
        $this->config = $config;
        $this->variably = $configHandler->getVariably();
        $this->configHandler = $configHandler;
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

    /**
     * Mark native value as array or not and return array
     * You must use this in strong order of cast() and back() method otherwise get unexpected behavior
     *
     * @param $value
     * @return mixed
     */
    protected function cast($value)
    {
        $isDeep = $this->isDeep($value);
        $this->cast[] = $isDeep;
        $value = $isDeep ? $value : [$value];

        return $value;
    }

    /**
     * @param $array
     * @return array
     */
    protected function back($array)
    {
        return array_pop($this->cast) ? $array : array_shift($array);
    }

    public function process($fields)
    {
        $collection = $this->cast($fields);

        foreach ($collection as $i => $fields) {
            //$collection = array_map(function ($fields) {
            $this->getVariably()->set('fields', $fields);
            $preFields = [];
            foreach ($this->config['fields'] as $name => $variable) {
                if (is_array($variable)) { // complex variable with __filter & __prepare
                    $values = array_map(function ($value) {
                        return $this->getVariably()->is($value)
                            ? $this->getVariably()->process($value)
                            : $value;
                    }, $this->cast($variable['value']));
                    $preFields[$name] = $this->getConfigHandler()->process($this->back($values), $variable);
                } elseif ($this->getVariably()->is($variable)) {
                    $preFields[$name] = $this->getVariably()->process($variable);
                } else {
                    $preFields[$name] = $variable;
                }
            };
            //return array_merge({}, /*fields,*/ preFields);

            $collection[$i] = $preFields;
            //}, $collection);
        }

        //return isArray ? collection : collection.shift();
        return $this->back($collection);
    }

    protected function isDeep($array)
    {
        if (!is_array($array)) {
            return false;
        }

        foreach ($array as $elm) {
            if (is_array($elm)) {
                return true;
            }
        }

        return false;
    }
}


