<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 04.09.13
 * Time: 13:48
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


class Buttons extends \Frontend implements \Iterator
{
	protected $strTemplate = 'bootstrap_buttons';

	protected $arrButtons = array();

	protected $arrConfiguration = array();

	protected $blnToolbar = false;

	protected $intIndex = 0;


	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
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
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		$this->intIndex = 0;
	}


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
	 *
	 * @param array $item
	 * @param bool  $first
	 * @param bool  $createGroup
	 */
	public function addItem(array $item, $first=false, $createGroup=false)
	{
		$this->addItemToTarget($this->arrButtons, $item, $first, $createGroup);
	}

	public function count()
	{
		return count($this->arrButtons);
	}

	public function getContainerType()
	{
		return $this->toolbar ? 'toolbar' : 'group';
	}

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