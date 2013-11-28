<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 06.09.13
 * Time: 23:05
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\Iterator;

/**
 * Class CallbackModifyIterator
 * @package Netzmacht\Bootstrap
 */
class ArrayCallbackModify extends ArrayOuter
{
	protected $cachedCurrent;

	/**
	 * @var int
	 */
	protected $callback;


	/**
	 * @param \Iterator $iterator
	 * @param callable  $callback
	 */
	public function __construct(\Iterator $iterator, $callback)
	{
		parent::__construct($iterator);

		$this->callback = $callback;
	}


	/**
	 * @return mixed
	 */
	public function current()
	{
		return call_user_func($this->callback, parent::current(), $this->key(), $this);
	}

}