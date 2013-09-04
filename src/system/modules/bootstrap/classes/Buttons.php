<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 04.09.13
 * Time: 13:48
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


class Buttons
{
	protected $buttons = array();
	protected $toolbar = false;

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
		$this->addItemToTarget($this->buttons, $item, $first, $createGroup);
	}

	public function count()
	{
		return count($this->buttons);
	}

	public function getContainerType()
	{
		return $this->toolbar ? 'toolbar' : 'group';
	}

	public function getItems()
	{
		return $this->buttons;
	}

	protected function addItemToTarget(array &$target, array $item, $first=false, $createGroup=false)
	{
		// make sure every key is set
		$item = array_merge(array(
				'type'      => '',
				'button'    => 'link',
				'attributes'=> '',
				'value'     => '',
				'title'     => '',
				'label'     => ''
			), $item
		);

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
			$end = end($this->buttons);

			if($end !== false && $end['type'] == 'group')
			{
				$item = array('type' => 'group', 'items' => array($item));
			}
		}

		$target[] = $item;
	}
}