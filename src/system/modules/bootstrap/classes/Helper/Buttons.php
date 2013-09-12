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

namespace Netzmacht\Bootstrap\Helper;


/**
 * Class Buttons is a component for displaying buttons
 * @package Netzmacht\Bootstrap
 */
class Buttons extends \Frontend implements \Iterator
{

	/**
	 * @var string
	 */
	protected $strTemplate = 'bootstrap_buttons';

	/**
	 * @var array
	 */
	protected $arrButtons = array();

	/**
	 * @var array
	 */
	protected $arrConfiguration = array();

	/**
	 * render as toolbar
	 *
	 * @var bool
	 */
	protected $blnToolbar = false;

	/**
	 * index for button iterator
	 * @var int
	 */
	protected $intIndex = 0;


	/**
	 * make constructor public
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * add class dynamically
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 *
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current()
	{
		$current= $this->arrButtons[$this->intIndex];

		if(!isset($current['class']))
		{
			$current['class'] = $this->buttonStyle;
		}

		return $current;
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 *
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		++$this->intIndex;
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 *
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key()
	{
		return $this->intIndex;
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 *
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 *       Returns true on success or false on failure.
	 */
	public function valid()
	{
		return isset($this->arrButtons[$this->intIndex]);
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 *
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		$this->intIndex = 0;
	}


	/**
	 * @param string $key
	 *
	 * @return array|bool|mixed|null|string
	 */
	public function __get($key)
	{
		switch($key)
		{
			case 'toolbar':
				return $this->blnToolbar;
				break;

			case 'buttons':
				return $this->arrButtons;
				break;

			case 'buttonStyle':
				if(!isset($this->arrConfiguration[$key]) || $this->arrConfiguration[$key] == '')
				{
					return 'btn-default';
				}

				// no break

			default:
				if(isset($this->arrConfiguration[$key]))
				{
					return $this->arrConfiguration[$key];
				}

				break;
		}

		return parent::__get($key);
	}


	/**
	 * @param $key
	 * @param $value
	 */
	public function __set($key, $value)
	{
		$this->arrConfiguration[$key] = $value;
	}


	/**
	 * load buttons defined in a field set definition, created by the MultiColumnWizard
	 * @param $definition
	 */
	public function loadFromFieldset($definition)
	{
		if(!is_array($definition))
		{
			$definition = deserialize($definition, true);
		}

		$buttons  = array();
		$group    = false;
		$dropdown = false;

		foreach($definition as $button)
		{
			if($button['label'] == '' && $button['type'] != 'group')
			{
				continue;
			}

			// encode value
			if(isset($button['button']) && $button['button'] == 'link')
			{
				if (substr($button['value'], 0, 7) == 'mailto:')
				{
					$button['value'] = \String::encodeEmail($button['value']);
				}
				else
				{
					$button['value'] = ampersand($button['value']);
				}
			}

			if($dropdown !== false && ($button['type'] != 'child' && $button['type'] != 'header'))
			{
				if($group !== false)
				{
					$this->addItemToTarget($group['items'], $dropdown);
				}
				else
				{
					$this->addItem($dropdown);
				}

				$dropdown = false;
			}

			// create new group
			if($button['type'] == 'group')
			{
				$this->toolbar = true;

				if($group !== false)
				{
					$buttons[] = $group;
				}

				$group = $button;
				$group['items'] = array();
			}

			// create dropdown
			elseif($button['type'] == 'dropdown')
			{
				$dropdown = $button;
				$dropdown['items'] = array();
			}

			// add dropdown child
			elseif($button['type'] == 'child' || $button['type'] == 'header')
			{
				$dropdown['items'][] = $button;
			}

			// add button
			elseif($group !== false)
			{
				$this->addItemToTarget($group['items'], $button);
			}
			else
			{
				$this->addItem($button);
			}
		}

		if($group !== false)
		{
			if($dropdown !== false)
			{
				$this->addItemToTarget($group['items'], $dropdown);
			}

			$this->addItem($group);
		}
		elseif($dropdown !== false)
		{
			$this->addItem($dropdown);
		}
	}


	/**
	 * add item to button component
	 * @param array $item
	 * @param bool  $first
	 * @param bool  $createGroup
	 */
	public function addItem(array $item, $first=false, $createGroup=false)
	{
		$this->addItemToTarget($this->arrButtons, $item, $first, $createGroup);
	}


	/**
	 * count first level elements
	 * @return int
	 */
	public function count()
	{
		return count($this->arrButtons);
	}


	/**
	 * is component a group or toolbar
	 * @return string
	 */
	public function getContainerType()
	{
		return $this->toolbar ? 'toolbar' : 'group';
	}


	/**
	 * add item to a target, used for subitems and button component itself
	 *
	 * @param array $target
	 * @param array $item
	 * @param bool  $first
	 * @param bool  $createGroup
	 */
	protected function addItemToTarget(array &$target, array $item, $first=false, $createGroup=false)
	{
		// make sure every key is set
		$item = array_merge(array(
				'type'      => '',
				'button'    => 'link',
				'attributes'=> '',
				'url'       => '',
				'label'     => ''
			), $item
		);

		// set attribute as param
		$pattern = '/class\s*=\s*\"([^\"]*)\s*"/i';

		if(!isset($item['class']) && preg_match($pattern, $item['attributes'], $matches))
		{
			$item['class'] = $matches[1];
			preg_replace($pattern, '', $item['attributes']);
		}

		if($first)
		{
			if($createGroup && isset($target[0]) && $target[0]['type'] == 'group')
			{
				$item = array('type' => 'group', 'items' => array($item));
			}

			$target = array_merge(array($item), $target);
			return;
		}

		if($createGroup)
		{
			$end = end($this->arrButtons);

			if($end !== false && $end['type'] == 'group')
			{
				$item = array('type' => 'group', 'items' => array($item));
			}
		}

		$target[] = $item;
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		if($this->addContainer === null)
		{
			$this->addContainer = $this->count() > 0;
		}

		$this->containerClass = 'btn-' . $this->getContainerType();

		ob_start();
		include $this->getTemplate($this->strTemplate);
		$buffer = ob_get_contents();
		ob_end_clean();

		return $buffer;
	}

}