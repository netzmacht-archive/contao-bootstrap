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

namespace Netzmacht\Bootstrap;

/**
 * Class TemplateModifier contains all template modifiers used by bootstrap config
 * @package Netzmacht\Bootstrap
 */
class TemplateModifier
{


	/**
	 * @param \Template $template modifier
	 */
	public static function addActiveClassToTrailItem(\Template $template)
	{
		$items = $template->items;

		foreach($items as $i => $item)
		{
			if(strpos($item['class'], 'trail') !== false)
			{
				$items[$i]['class'] .= ' active';
			}
		}

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

}