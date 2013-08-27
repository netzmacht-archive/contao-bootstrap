<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   netzmacht-bootstrap
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap;


/**
 * Class ContentTab
 *
 * @package Netzmacht\Bootstrap
 */
class ContentTab extends BootstrapWrapperElement
{

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_tab';

	/**
	 * @var string
	 */
	protected static $strWrapperName = 'tabs';

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('subType', 'fade', 'tabs');


	/**
	 * prepare tab content element
	 * @param $objElement
	 */
	public function __construct($objElement)
	{
		parent::__construct($objElement);

		// load tab definitions
		if($this->type == static::getName('start'))
		{
			static::$arrStartElement[static::$strWrapperName] = array();
			$tabs = deserialize($this->tabs, true);

			foreach ($tabs as $i => $tab)
			{
				$tabs[$i]['id'] = standardize($tab['title']);
			}

			$start['tabs'] = $tabs;
		}

		// get current tab index
		if($start['tabIndex'] === null)
		{
			$start['tabIndex'] = -1;
		}

		do
		{
			$start['tabIndex']++;
		} while (isset($start['tabs'][$start['tabIndex']]) &&
			$start['tabs'][$start['tabIndex']]['type'] == 'dropdown');

		static::$arrStartElement[static::$strWrapperName] = $start;
	}

	/**
	 * compile tabs
	 */
	protected function compile()
	{
		$start = self::getStartElement();

		$this->tabs = $start['tabs'];
		$this->fade = $start['bootstrap_fade'];
		$this->Template->tabIndex = $start['tabIndex'];

		parent::compile();
	}


	/**
	 * @return string
	 */
	protected function generateTitle()
	{
		$start = self::getStartElement();

		if($start['tabs'][$start['tabIndex']]['title'] != '') {
			return '<strong class="title">' . $start['tabs'][$start['tabIndex']]['title'] . '</strong>';
		}
	}

}