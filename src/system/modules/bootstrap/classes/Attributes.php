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
 * Class Attributes allows access values using array style or object style. It adds a namespace for bootstrap
 * attributes, so instead of bootstrap_attribute you can access them with attribute
 *
 * @package Netzmacht\Bootstrap
 */
class Attributes extends \ArrayObject
{

	/**
	 * Attributes which have a namespace
	 * @var array
	 */
	protected $bootstrapNameSpace = array();


	/**
	 * Data can be empty, an arry, a model or a model collection
	 * @param array|null|object $data
	 */
	public function __construct($data=null)
	{
		if($data instanceof \Model || $data instanceof \Model\Collection)
		{
			$data = $data->row();
		}

		parent::__construct($data);
	}


	/**
	 * delegate to offsetGet
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->offsetGet($key);
	}


	/**
	 * delegate to offsetSet
	 *
	 * @param $key
	 * @param $value
	 */
	public function __set($key, $value)
	{
		$this->offsetSet($key, $value);
	}


	/**
	 * delegate to offsetExists
	 *
	 * @param $key
	 * @return bool
	 */
	public function __isset($key)
	{
		return $this->offsetExists($key);
	}


	/**
	 * delegate to offsetUnset
	 *
	 * @param $key
	 */
	public function __unset($key)
	{
		$this->offsetUnset($key);
	}


	/**
	 * get attribute
	 *
	 * @param mixed $key
	 * @return mixed
	 */
	public function &offsetGet($key)
	{
		return parent::offsetGet($this->getKey($key));
	}


	/**
	 * set new attribute
	 *
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function offsetSet($key, $value)
	{
		parent::offsetSet($this->getKey($key), $value);
	}


	/**
	 * check if attribute exists
	 *
	 * @param mixed $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return parent::offsetExists($this->getKey($key));
	}


	/**
	 * unset current attribute
	 *
	 * @param mixed $key
	 * @return bool
	 */
	public function offsetUnset($key)
	{
		return parent::offsetExists($this->getKey($key));
	}


	/**
	 * register attributes which have a namespace
	 *
	 * @param array $attributes
	 */
	public function registerNamespaceAttributes(array $attributes)
	{
		$this->bootstrapNameSpace = $attributes;
	}


	/**
	 * get key with namespace if required
	 *
	 * @param $key
	 * @return string
	 */
	protected function getKey($key)
	{
		if(in_array($key, $this->bootstrapNameSpace))
		{
			$key = 'bootstrap_' . $key;
		}

		return $key;
	}

}