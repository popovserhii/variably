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

namespace Popov\Variably\Helper;

use Popov\Variably\Variably;

class HelperAbstract
{
    /**
     * @var Variably
     */
    protected $variably;

    protected $config = [];

    protected $defaultConfig = [];

    protected $stashConfig = [];

    public function setVariably(Variably $variably)
    {
        $this->variably = $variably;

        return $this;
    }

    public function getVariably()
    {
        return $this->variably;
    }

    public function setStashConfig($config)
    {
        // define getter for default config
        $this->stashConfig = $this->defaultConfig
            ? array_merge_recursive($this->defaultConfig, $config)
            : $config;

        $this->config = $this->stashConfig;

        return $this;
    }

    public function resetConfig()
    {
        $this->config = $this->stashConfig;

        return $this;
    }

    public function mergeConfig($config)
    {
        //this.config = _.merge(this.config, config);
        $this->config = array_merge_recursive($this->config, $config);

        return $this;
    }

    public function setConfig($key, $value)
    {
        $this->config[$key] = $value;

        return $this;
    }

    public function getConfig($key = null)
    {
        if (!$key) {
            return $this->config;
        }

        return isset($this->config[$key])
            ? $this->config[$key]
            : false;
    }
}