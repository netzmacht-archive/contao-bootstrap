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
 * Class BootstrapContentElement provides access to bootstrap namespaced elements
 * @package Netzmacht\Bootstrap
 */
class BootstrapContentElement extends \ContentElement
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
	 * compile bootstrap content element
	 */
	protected function compile()
	{
		foreach ($this->arrBootstrapAttributes as $attribute)
		{
			$this->Template->$attribute = $this->arrData['bootstrap_' . $attribute];
		}
	}


}
