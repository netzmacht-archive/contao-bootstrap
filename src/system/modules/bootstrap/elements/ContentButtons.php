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
 * Class ContentToolbar
 * @package Netzmacht\Bootstrap
 */
class ContentButtons extends BootstrapContentElement
{

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('buttons', 'buttonStyle');

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_buttons';


	/**
	 * compile the button toolbar
	 */
	protected function compile()
	{
		$this->buttons = deserialize($this->buttons);

		$buttons  = array();
		$group    = false;
		$dropdown = false;

		if($this->buttonStyle == '')
		{
			$this->buttonStyle = 'btn-default';
		}

		foreach($this->buttons as $button)
		{
			// encode url
			if (substr($button['url'], 0, 7) == 'mailto:')
			{
				$button['url'] = \String::encodeEmail($button['url']);
			}
			else
			{
				$button['url'] = ampersand($button['url']);
			}

			if($dropdown !== false && ($button['type'] != 'child' && $button['type'] != 'header'))
			{
				if($group !== false)
				{
					$group['items'][] = $dropdown;
				}
				else
				{
					$buttons[] = $dropdown;
				}

				$dropdown = false;
			}

			// create new group
			if($button['type'] == 'group')
			{
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
				$group['items'][] = $button;
			}
			else
			{
				$buttons[] = $button;
			}
		}

		if($group !== false)
		{
			if($dropdown !== false)
			{
				$group['items'][] = $dropdown;
			}

			$buttons[] = $group;
		}
		elseif($dropdown !== false)
		{
			$buttons[] = $dropdown;
		}

		$this->Template->addContainer = (count($buttons) > 1);
		$this->Template->buttons = $buttons;

		if($this->cssID[1] == '')
		{
			$this->Template->containerClass = $group ? 'btn-toolbar' : 'btn-group';
		}

		else
		{
			$cssID = $this->cssID;
			$this->Template->containerClass = $cssID[1];

			$cssID[1] = '';
			$this->cssID = $cssID;
		}
	}

}