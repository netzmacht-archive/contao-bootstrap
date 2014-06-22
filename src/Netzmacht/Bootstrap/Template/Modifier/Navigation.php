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

				if($item['subitems'])
				{
					$item['toggle'] = 'class="dropdown-toggle"';

					// m17 page folder items are handled as folders as well
					if($item['type'] == 'm17Folder' && $template->level != 'level_1')
					{
						$item['isHeader'] = !$template->disableUl;
						$item['toggle'] .= ' data-toggle="collapse"';
					}
					else {
						$item['itemClass'] = ($item['class'] == '' ? '' : ' ') . 'dropdown';
						$item['link']   .= ' ' . $GLOBALS['BOOTSTRAP']['dropdown']['toggle'];
						$item['toggle'] .= ' data-toggle="dropdown"';
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