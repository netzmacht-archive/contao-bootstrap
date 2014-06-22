<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 15.09.13
 * Time: 17:00
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\Template\Modifier;

use Netzmacht\Bootstrap\Iterator;

class Navigation
{
	/**
	 * @param \Template $template modifier
	 */
	public static function addActiveClassToTrailItem(\Template $template)
	{
		if(!$template->items instanceof \Traversable)
		{
			$template->items = new \ArrayIterator($template->items);
		}

		$items = new Iterator\ArrayCallbackModify($template->items,
			function($item)
			{
				if(strpos($item['class'], 'trail') !== false)
				{
					$item['class'] .= ' active';
				}

				return $item;
			}
		);

		$template->items = $items;
	}


	public static function setNavigationLevel(\Template $template)
	{
		$level = substr($template->level, 6);

		switch($level)
		{
			case '1':
				$template->navType = ' nav navbar-nav';

				break;

			case '2':
				$template->navType = ' dropdown-menu';
				break;

			default:
				$template->navType = ' dropdown-menu collapse'; //nav nav-dropdown collapse';
				break;
		}

		$template->disableUl = ($template->items && ($level != 1 && ($level % 2) == 1));

		if(!$template->items instanceof \Traversable)
		{
			$template->items = new \ArrayIterator($template->items);
		}

		$template->items = new Iterator\ArrayCallbackModify
		(
			new Iterator\ArrayCallbackFilter
			(
				$template->items,

				// filter all empty folder elements
				function($item)
				{
					return ($item['type'] != 'm17Folder' || $item['subitems']);
				}
			),

			function($item) use($template, $level)
			{
				$item['hideNavClass'] = true;
				$item['itemClass'] = ($item['class'] == '' ? '' : ' ') . 'dropdown';

				if($item['subitems'])
				{
					if($item['type'] == 'm17Folder')
					{
						if($level == 1 || $template->disableUl)
						{
							$item['link'] .= ' ' . $GLOBALS['BOOTSTRAP']['dropdown']['toggle'];
						}
					}
					else {
						$item['link'] .= ' ' . $GLOBALS['BOOTSTRAP']['dropdown']['toggle'];
					}

					$item['toggle'] = 'class="dropdown-toggle"';


					if($item['type'] == 'm17Folder')
					{
						if($template->level == 'level_1')
						{
							$item['toggle'] .= ' data-toggle="dropdown"';
						}
						else {
							$item['isHeader'] = !$template->disableUl;
							$item['toggle'] .= ' data-toggle="collapse"';
						}
					}
				}

				return $item;
			}
		);
	}

	public static function replaceNavClassPlaceholder(\Template $template)
	{
		if($template->bootstrap_inNavbar)
		{
			if($template->bootstrap_navbarFloating == 'right')
			{
				return 'navbar-right';
			}

			return '';
		}

		return $template->bootstrap_navClass == '' ? 'nav nav-default' : $template->bootstrap_navClass;
	}

}