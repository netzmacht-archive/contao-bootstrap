<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17.12.13
 * Time: 07:31
 */

namespace Netzmacht\Bootstrap\Model\ContentWrapper;


/**
 * Class ContentWrapper
 * @package Netzmacht\Bootstrap\Model
 */
class Model
{
	/**
	 * start type
	 *
	 * @var string
	 */
	const TYPE_START = 'start';

	/**
	 * separator type
	 *
	 * @var string
	 */
	const TYPE_SEPARATOR = 'separator';

	/**
	 * stop type
	 *
	 * @var string
	 */
	const TYPE_STOP = 'stop';


	/**
	 * @var \ContentModel
	 */
	protected $model;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $group;


	/**
	 * @param \ContentModel $model
	 */
	public function __construct(\ContentModel $model)
	{
		$this->model = $model;
	}


	/**
	 * Clone the model
	 */
	public function __clone()
	{
		$this->model = clone $this->model;
	}


	/**
	 * Set a value
	 *
	 * @param $key
	 * @param $value
	 */
	public function __set($key, $value)
	{
		$this->model->__set($key, $value);
	}


	/**
	 * Get the value of a key
	 *
	 * @param $key
	 * @return mixed|null
	 */
	public function __get($key)
	{
		return $this->model->__get($key);
	}


	/**
	 * @param $method
	 * @param $arguments
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->model, $method), $arguments);
	}


	/**
	 * Check wether key exists
	 *
	 * @param $key
	 * @return bool
	 */
	public function __isset($key)
	{
		return $this->model->__isset($this->model->$key);
	}


	/**
	 * @return \ContentModel
	 */
	public function getModel()
	{
		return $this->model;
	}


	/**
	 * @return array
	 */
	public function row()
	{
		return $this->model->row();
	}


	/**
	 * get type of element
	 *
	 * @return int
	 * @throws \Exception
	 */
	public function getType()
	{
		if($this->type !== null || $this->initialize()) {
			return $this->type;
		}

		throw new \Exception('Could not detect wrapper type of Content Element');
	}


	/**
	 * get group of element
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getGroup()
	{
		if($this->group !== null || $this->initialize()) {
			return $this->group;
		}

		throw new \Exception('Could not detect wrapper group of Content Element');
	}


	/**
	 * get type name
	 *
	 * @param null $type
	 * @return mixed
	 */
	public function getTypeName($type = null)
	{
		$group = $this->getGroup();
		$type  = $type === null ? $this->getType() : $type;

		return $GLOBALS['BOOTSTRAP']['wrappers'][$group][$type]['name'];
	}


	/**
	 * initialize element
	 *
	 * @return bool
	 */
	protected function initialize()
	{
		foreach($GLOBALS['BOOTSTRAP']['wrappers'] as $groupName => $group) {
			foreach($group as $type => $config) {
				if($config['name'] == $this->model->type) {
					$this->group = $groupName;
					$this->type  = $type;
					return true;
				}
			}
		}

		return false;
	}

}
