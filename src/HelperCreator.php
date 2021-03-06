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

use Popov\Variably\Helper;
use Psr\Container\ContainerInterface;

class HelperCreator
{
    /** @var ContainerInterface */
    protected $container;

    /** @var array */
    protected $config = [];

    protected $helpers = [
        'IntFilter' => Helper\FilterInt::class,
        'FloatFilter' => Helper\FilterFloat::class,
        'ShiftFilter' => Helper\FilterShift::class,
        'PopFilter' => Helper\FilterPop::class,
        'ExplodeFilter' => Helper\FilterExplode::class,
        'NumberFilter' => Helper\FilterNumber::class,
        'MergeFilter' => Helper\FilterMerge::class,
        'ReplaceFilter' => Helper\FilterReplace::class,
        'ToArrayFilter' => Helper\FilterToArray::class,
        'ToLowerFilter' => Helper\FilterToLower::class,
        'ToUpperFilter' => Helper\FilterToUpper::class,
        'RegexMatchFilter' => Helper\FilterRegexMatch::class,
        'ConcatFilter' => Helper\FilterConcat::class,
        'CastDeepFilter' => Helper\FilterCastDeep::class,
        'JsonEncodeFilter' => Helper\FilterJsonEncode::class,
        'MappingFilter' => Helper\FilterMapping::class,
        'DateExcelFilter' => Helper\FilterDateExcel::class,
        'DateNativeFilter' => Helper\FilterDateNative::class,
        'DateTimeFilter' => Helper\FilterDateTime::class,
        'TrimFilter' => Helper\FilterTrim::class,
        'UnshiftFilter' => Helper\FilterUnshift::class,
        'Br2nlFilter' => Helper\FilterBr2nl::class,
        'HtmlEntityDecodeFilter' => Helper\FilterHtmlEntityDecode::class,
        'PercentToNumberFilter' => Helper\FilterPercentToNumber::class,
        'PercentageToQuantityFilter' => Helper\FilterPercentageToQuantity::class,
        'GetFilter' => Helper\FilterGet::class,
        'SimpleFilter' => Helper\FilterSimple::class,
        'StripTagsFilter' => Helper\FilterStripTags::class,
        'MultiExplodeFilter' => Helper\FilterMultiExplode::class,

        'WatchChangePrepare' => Helper\PrepareWatchChange::class,
        'XUpdatePrepare' => Helper\PrepareXUpdate::class,
    ];

    public function __construct(ContainerInterface $container = null, array $config = null)
    {
        //$config = isset($config['importer']) ? $config['importer'] : $config;
        //$conf = [];
        $conf['helpers'] = isset($config['helpers']) ? $config['helpers']: [];
        $this->mergeConfig($conf);

        $this->container = $container;
        //$this->config = $conf;
    }

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function mergeConfig($config)
    {
        $config['helpers'] = array_merge($this->helpers, (isset($config['helpers']) ? $config['helpers']: []));

        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    //public function create($name, $type)
    public function create($helperName)
    {
        //$helperName = ucfirst($name) . ucfirst($type);
        if (isset($this->config['helpers'][$helperName])) {
            $helperName = $this->config['helpers'][$helperName];
        }

        $helper = $this->createHelper($helperName);

        return $helper;
    }

    /**
     * Create driver using Container or "new" operator
     *
     * @param string $helperName
     * @return mixed
     */
    protected function createHelper($helperName)
    {
        return isset($this->container)
            ? $this->container->get($helperName)
            : new $helperName();
    }

    /**
     * Get standardizes config key
     *
     * @param $key
     * @return string
     */
    protected function getConfigKey($key)
    {
        return strtolower(preg_replace("/[^A-Za-z0-9]/", '', $key));
    }
}