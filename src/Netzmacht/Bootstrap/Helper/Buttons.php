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

use Netzmacht\Bootstrap\Iterator\ArrayCallbackModify;


/**
 * Class Buttons is a component for displaying buttons
 * @package Netzmacht\Bootstrap
 */
class Buttons extends \Frontend
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
				$style = $this->buttonStyle;
				$callback = function($item) use($style, &$callback)
				{
					if($item['class'] == '')
					{
						$item['class'] = $style;
					}

					if(isset($item['items']))
					{
						$item['items'] = new ArrayCallbackModify(new \ArrayIterator($item['items']), $callback);
					}

					return $item;
				};

				return new ArrayCallbackModify(
					new \ArrayIterator($this->arrButtons), $callback
				);

				break;

			case 'buttonStyle':
				if(!isset($this->arrConfiguration[$key]) || $this->arrConfiguration[$key] == '')
				{
					return 'btn btn-default';
				}

				return $this->arrConfiguration[$key];

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
		switch($key)
		{
			case 'toolbar':
				$this->blnToolbar = $value;
				break;

			default:
				$this->arrConfiguration[$key] = $value;
		}
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

				if($dropdown !== false)
				{
					if($group)
					{
						$this->addItemToTarget($group['items'], $dropdown);
					}
					else
					{
						$this->addItem($dropdown);
					}

					$dropdown = false;
				}

				if($group !== false)
				{
					$this->addItem($group);
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
				'attributes'=> array(),
				'url'       => '',
				'label'     => ''
			), $item
		);

		// set attribute as param
		if(!isset($item['class']) && $item['attributes']['class'])
		{
			$item['class'] = $item['attributes']['class'];
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
			$this->addContainer = ($this->count() > 0);
		}

		$this->containerClass = 'btn-' . $this->getContainerType();

		ob_start();
		include $this->getTemplate($this->strTemplate);
		$buffer = ob_get_contents();
		ob_end_clean();

		return $buffer;
	}

}