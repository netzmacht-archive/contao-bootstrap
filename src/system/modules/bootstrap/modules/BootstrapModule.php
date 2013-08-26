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
 * Class BootstrapModule provides easy access for bootstrap namespaces attributes
 *
 * @package Netzmacht\Bootstrap
 */
abstract class BootstrapModule extends \Module
{

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array();


	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if(in_array($key, $this->arrBootstrapAttributes))
		{
			return $this->arrData['bootstrap_' . $key];
		}

		return parent::__get($key);
	}


	/**
	 * @param $key
	 * @param $value
	 */
	public function __set($key, $value)
	{
		if(in_array($key, $this->arrBootstrapAttributes))
		{
			$key = 'bootstrap_' . $key;
		}

		parent::__set($key, $value);
	}


	/**
	 * compile bootstrap module
	 */
	protected function compile()
	{
		foreach ($this->arrBootstrapAttributes as $attribute)
		{
			$this->Template->$attribute = $this->arrData['bootstrap_' . $attribute];
		}
	}

}