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

namespace Netzmacht\Bootstrap\Template;

use Netzmacht\Bootstrap\Attributes;
use Netzmacht\Bootstrap\Bootstrap;
use Netzmacht\Bootstrap\Iterator;

/**
 * Class TemplateModifier contains all template modifiers used by bootstrap config
 * @package Netzmacht\Bootstrap
 */
class Modifier
{

	/**
	 * execute all registered template modifiers
	 *
	 * @param \Template $template
	 */
	public function execute(\Template $template)
	{
		if(!Bootstrap::isEnabled())
		{
			return;
		}

		foreach($GLOBALS['BOOTSTRAP']['templates']['modifiers'] as $config)
		{
			if(!in_array($template->getName(), $config['templates']))
			{
				continue;
			}

			if($config['type'] == 'replace')
			{
				if(is_callable($config['replace']))
				{
					$value = call_user_func($config['replace'], $template);
				}
				else
				{
					$value = $config['replace'];
				}

				$template->$config['key'] = str_replace($config['search'], $value, $template->$config['key']);
			}
			elseif($config['type'] == 'callback')
			{
				call_user_func($config['callback'], $template);
			}
		}
	}


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


	/**
	 * @param \Template $template
	 */
	public static function setPanelDefaultClass(\Template $template)
	{
		$classes = array(
			'accordionStart' => 'ce_accordionStart',
			'accordionSingle' => 'ce_accordionSingle',
		);

		if($template->class != $classes[$template->type])
		{
			return;
		}

		switch($template->type)
		{
			case 'accordionStart':
			case 'accordionSingle':
				$template->class = $template->class . ' panel-default';
				break;
		}
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
						$item['itemClass'] .= ' navbar-group';
						$item['subitems']   = sprintf(
							'<a href="#" class="dropdown-toggle" data-toggle="%s">%s</a>%s',
							$template->level == 'level_1' ? 'dropdown' : 'collapse',
							$GLOBALS['BOOTSTRAP']['dropdown']['toggle'],
							$item['subitems']
						);
					}

					if($template->level == 'level_1')
					{
						$item['toggle'] = 'class="dropdown-toggle"';

						if($item['type'] == 'm17Folder')
						{
							$item['toggle'] .= ' data-toggle="dropdown"';
						}
					}
					else
					{
						$item['toggle'] = 'class="dropdown-toggle"';

						if($item['type'] == 'm17Folder')
						{
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

	public static function initializeGrid(\Template $template)
	{
		$template->useGrid = true;

		$layout = Bootstrap::getLayout();
		$class  = ' class="%s"';

		switch($layout->cols)
		{
			case '2cll':
				$template->leftClass           = $layout->bootstrap_leftClass;
				$template->mainClass           = $layout->bootstrap_mainClass;

				$template->mainClassAttribute  = sprintf($class, $layout->bootstrap_mainClass);
				$template->leftClassAttribute  = sprintf($class, $layout->bootstrap_leftClass);
				break;

			case '2clr':
				$template->rightClass          = $layout->bootstrap_rightClass;
				$template->mainClass           = $layout->bootstrap_mainClass;

				$template->mainClassAttribute  = sprintf($class, $layout->bootstrap_mainClass);
				$template->rightClassAttribute = sprintf($class, $layout->bootstrap_rightClass);
				break;

			case '3cl':
				$template->leftClass           = $layout->bootstrap_leftClass;
				$template->rightClass          = $layout->bootstrap_rightClass;
				$template->mainClass           = $layout->bootstrap_mainClass;

				$template->mainClassAttribute  = sprintf($class, $layout->bootstrap_mainClass);
				$template->rightClassAttribute = sprintf($class, $layout->bootstrap_rightClass);
				$template->leftClassAttribute  = sprintf($class, $layout->bootstrap_leftClass);
				break;

			default:
				$template->useGrid = false;
		}

		switch($layout->rows)
		{
			case '2rwh':
				$template->headerClass           = $layout->bootstrap_headerClass;

				$template->headerClassAttribute = sprintf($class, $layout->bootstrap_headerClass);
				break;

			case '2rwf':
				$template->footerClass           = $layout->bootstrap_footerClass;

				$template->footerClassAttribute = sprintf($class, $layout->bootstrap_footerClass);
				break;

			case '3rw':
				$template->headerClass           = $layout->bootstrap_headerClass;
				$template->footerClass           = $layout->bootstrap_footerClass;

				$template->headerClassAttribute = sprintf($class, $layout->bootstrap_headerClass);
				$template->footerClassAttribute = sprintf($class, $layout->bootstrap_footerClass);
				break;
		}

	}
}