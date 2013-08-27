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
 * Class BootstrapWrapperElement provides methods for generating wrapping elements like slider or tab
 *
 * @package Netzmacht\Bootstrap
 */
class BootstrapWrapperElement extends BootstrapContentElement
{

	/**
	 * @var string
	 */
	protected $strIdentifier = 'element-%s';

	/**
	 * store start element
	 * @var array
	 */
	protected static $arrStartElement;

	/**
	 * @var string
	 */
	protected static $strWrapperName = 'tabs';


	/**
	 * load start element
	 *
	 * @param $objElement
	 */
	public function __construct($objElement)
	{
		parent::__construct($objElement);

		// load start element
		if($this->type == static::getName('start'))
		{
			static::$arrStartElement[static::$strWrapperName] = $this->arrData;
		}
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		// backend mode
		if(TL_MODE == 'BE')
		{
			if(static::getName('stop') == $this->type) {
				return '';
			}
			return $this->generateTitle();
		}

		$generated = parent::generate();

		// reset start element
		if($this->type == static::getName('stop'))
		{
			static::$arrStartElement[static::$strWrapperName] = null;
		}

		return $generated;
	}


	/**
	 * get name of start part or end element
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public static function getName($key)
	{
		return $GLOBALS['BOOTSTRAP']['wrappers'][static::$strWrapperName][$key];
	}


	/**
	 * generate the title of a part
	 * @return string
	 */
	protected function generateTitle()
	{
		if(version_compare(VERSION, '3.1', '<'))
		{
			return '<strong class="title">' . $this->type . '</strong>';
		}
		return '';
	}


	/**
	 * @return mixed
	 */
	public static function getStartElement()
	{
		if(isset(static::$arrStartElement[static::$strWrapperName]))
		{
			return static::$arrStartElement[static::$strWrapperName];
		}

		return null;
	}

}