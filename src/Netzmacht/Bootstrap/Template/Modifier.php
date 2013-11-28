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
			if($config['disabled'] || !$this->isTemplateAffected($template->getName(), $config['templates']))
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

	protected function isTemplateAffected($template, $templates)
	{
		foreach($templates as $config)
		{
			if($template == $config)
			{
				return true;
			}
			elseif(substr($config, -1) == '*' && 0 == strcasecmp(
				substr($config, 0, -1),
				substr($template, 0, strlen($config) -1)
			)) {
				return true;
			}

		}

		return false;
	}

}