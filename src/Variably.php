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


class Variably
{
    protected $variables = [];

    // '/{{([a-zA-Z0-9\_\-.]*?)}}/i'
    //protected $regexp = "/{{([a-zA-Z0-9_\-.]*?)}}/gi";
    protected $regexp = "/{{([a-zA-Z0-9_\-.]*?)}}/i";

    /**
     * Set variable
     *
     * @param $name
     * @param $variable
     * @return self
     */
    public function set($name, $variable)
    {
        $this->variables[$name] = $variable;

        return $this;
    }

    /**
     * Get variable
     *
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->variables[$name] ?? false;
    }

    public function unset($name)
    {
        unset($this->variables[$name]);

        return $this;
    }

    /**
     * Is parameter stringable variable
     *
     * @param $varPattern
     * @return bool
     */
    public function is($varPattern)
    {
        return (is_string($varPattern) && (substr($varPattern, 0, 1) === '$'));
    }

    public function process($variable)
    {
        if ($this->is($variable)) {
            return $this->processValue(substr($variable, 1));
        }

        $variable = preg_replace_callback($this->regexp, function($match) {
            return $this->processValue($match[1]);
        }, $variable);

        return $variable;
    }

    protected function processValue($varPattern)
    {
        $path = explode('.', $varPattern);
        $objectName = array_shift($path);
        if (!isset($this->variables[$objectName])) {
            throw new \Exception('$' . $objectName . ' is not set in Variable Object');
        }
        $resolved = $this->variables[$objectName];
        foreach ($path as $part) {
            if (isset($resolved[$part])) {
                $resolved = $resolved[$part];
            } elseif (method_exists($resolved, 'getData')) {
                $resolved = $resolved->getData($part);
            } elseif (!isset($resolved[$part])) {
                $resolved = null;
                break;
            }
        }

        return $resolved;
    }
}