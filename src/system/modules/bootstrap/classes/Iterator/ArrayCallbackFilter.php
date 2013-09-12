<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 08.09.13
 * Time: 04:05
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\Iterator;


class ArrayCallbackFilter extends ArrayOuter
{

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

	public function valid()
	{
		while($this->getInnerIterator()->valid() && !call_user_func($this->callback, $this->current(), $this->key(), $this->getInnerIterator()))
		{
			$this->next();
		}

		return $this->getInnerIterator()->valid();
	}

}