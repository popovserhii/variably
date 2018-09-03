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
 * @package Popov_Variably
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Popov\Variably;

use __;
use Popov\Variably\Helper\HelperAbstract;
use Popov\Variably\Variably;
use Popov\Variably\HelperCreator;
use Zend\Filter\Word\DashToCamelCase;

class ConfigHandler
{
    /**
     * @var Variably
     */
    protected $variably;

    /**
     * @var HelperCreator
     */
    protected $helperCreator;

    /**
     * Override this property in Filter or Prepare class for set default config
     *
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var HelperAbstract[]
     */
    protected $helpers;

    protected $globalConfig = [];

    public function __construct(
        Variably $variably,
        HelperCreator $helperCreator,
        array $config = []
    )
    {
        $this->variably = $variably;
        $this->helperCreator = $helperCreator;
        $this->globalConfig = $config;
    }

    public function setConfig($config)
    {
        $this->globalConfig = $config;
        $this->helperCreator->mergeConfig($config);

        return $this;
    }

    public function getVariably()
    {
        return $this->variably;
    }

    /*public function getGlobalConfig()
    {
        return $this->globalConfig;
    }*/

    public function process($value, $fieldConfig)
    {
        $value = $this->processFilters($value, $fieldConfig);
        $value = $this->processPrepare($value, $fieldConfig);

        return $value;
    }

    protected function processFilters($value, $fieldConfig)
    {
        if (isset($fieldConfig['__filter'])) {
            foreach ($fieldConfig['__filter'] as $filter) {
                $filter = $this->parseHelperName($filter);
                $helper = $this->getHelper($filter['name'], 'filter');
                if ($helper instanceof HelperAbstract) {
                    $helper->mergeConfig($filter['config'])
                        ->mergeConfig(['params' => $filter['params']]);
                }
                $value = $helper->filter($value);
            }
        }

        return $value;
    }

    protected function processPrepare($value, $fieldConfig)
    {
        if (isset($fieldConfig['__prepare'])) {
            foreach ($fieldConfig['__prepare'] as $prepare) {
                $prepare = $this->parseHelperName($prepare);
                $helper = $this->getHelper($prepare['name'], 'prepare');
                if ($helper instanceof HelperAbstract) {
                    $helper->mergeConfig($prepare['config'])
                        ->mergeConfig(['params' => $prepare['params']]);
                }
                $value = $helper->prepare($value);
            }
        }

        return $value;
    }

    protected function parseHelperName($helper)
    {
        $parsed = ['name' => null, 'config' => [], 'params' => []];
        if (is_array($helper)) {
            $parsed = array_merge($parsed, $helper);
        } else if (false !== ($pos = strpos($helper, ':'))) { // helper name with params
            $name = substr($helper, 0, $pos);
            $params = substr($helper, $pos + 1) ?? '';
            $parsed['name'] = $name;
            $parsed['params'] = explode(',', $params);
        } else {
            $parsed['name'] = $helper;
        }

        $parsed['params'] = $this->processConfigVariables($parsed['params']);
        $parsed['config'] = $this->processConfigVariables($parsed['config']);

        return $parsed;
    }

    protected function processConfigVariables($config)
    {
        foreach ($config as $key => $param) {
            if (is_string($param)) {
                $config[$key] = $this->variably->process($param);
            } elseif (is_array($param)) {
                $config[$key] = $this->processConfigVariables($param);
            }
        };

        return $config;
    }

    protected function getHelper($name, $pool)
    {
        $name = (new DashToCamelCase())->filter($name);
        $name = ucfirst($name) . ucfirst($pool);

        // Text below isn't actual at that moment!
        // Now helpers caching is disable such as any helper can has different configuration on local level.
        // If leave this possibility here we can retrieve unexpected behavior
        // when config from different places will be merged in on helper

        if (isset($this->helpers[$name])) {
            if ($this->helpers[$name] instanceof HelperAbstract) {
                $this->helpers[$name]->resetConfig();
            }

            return $this->helpers[$name];
        }
        $helper = $this->helperCreator->create($name);

        if ($helper instanceof HelperAbstract) {
            $helper->setStashConfig($this->getHelperConfig($name))
                ->setVariably($this->variably);
        }

        //return $this->helpers[key] = new HelperClass($this->variably, $this->getHelperConfig(key));
        return $this->helpers[$name] = $helper;
    }

    protected function getHelperConfig($name)
    {
        if (!isset($this->defaultConfig[$name])) {
            #$config = $this->variably->get('config');
            $config = $this->globalConfig;

            $path = ['default'];
            if (isset($config['pool'])) {
                $path[] = 'pool';
                $path[] = $config['pool'];
            }
            $path[] = 'helper';
            $path[] = $name;

            $configPath = implode('.', $path);
            $this->defaultConfig[$name] = (__::has($this->globalConfig, $configPath))
                ? __::get($this->globalConfig, $configPath)
                : [];
        }

        return $this->defaultConfig[$name];
    }
}