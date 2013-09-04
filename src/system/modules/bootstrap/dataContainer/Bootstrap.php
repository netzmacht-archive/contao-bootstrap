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

namespace Netzmacht\Bootstrap\DataContainer;

use Netzmacht\Bootstrap\BootstrapWidget;
use Netzmacht\Bootstrap\Icons;

/**
 * Class BootstrapDataContainer
 *
 * @package Netzmacht\Bootstrap
 */
class Bootstrap extends \Backend
{

	/**
	 * @var bool
	 */
	protected static $bootstrapLoaded = false;

	/**
	 * @var \LayoutModel
	 */
	protected static $pageLayout;


	/**
	 * Get all modules prepared for select wizard
	 *
	 * @return array
	 */
	public function getAllModules()
	{
		$arrModules = array();

		$objModules = $this->Database
			->execute("SELECT m.id, m.name, t.name AS theme FROM tl_module m LEFT JOIN tl_theme t ON m.pid=t.id ORDER BY t.name, m.name");

		while ($objModules->next())
		{
			$arrModules[$objModules->theme][$objModules->id] = $objModules->name . ' (ID ' . $objModules->id . ')';
		}

		return $arrModules;
	}


	/**
	 * We need to use the parseTemplate callback to trigger initializeLayout in Contao 3.
	 *
	 */
	public function initializeLayoutByParseTemplateHook()
	{
		global $objPage;

		if(static::$bootstrapLoaded || !$objPage)
		{
			return;
		}

		static::$bootstrapLoaded = true;

		$this->initializeLayout($objPage, self::getPageLayout());
	}


	/**
	 * only load templates if bootstrap is activated, so diverent layouts will work instead of template changes
	 *
	 * @param \PageModel   $page
	 * @param \LayoutModel $layout
	 */
	public function initializeLayout(\PageModel $page, \LayoutModel $layout)
	{
		static::$pageLayout = $layout;

		if($layout->addBootstrap)
		{
			// only load these templates if layout uses it because default templates are changed
			foreach ($GLOBALS['BOOTSTRAP']['templates']['dynamicLoad'] as $path => $templates)
			{
				foreach ($templates as $template)
				{
					\TemplateLoader::addFile($template, $path);
				}
			}

			// load assets
			$layout->bootstrap_assets = deserialize($layout->bootstrap_assets, true);

			foreach ($layout->bootstrap_assets as $asset)
			{
				$extension = substr($asset, strrpos($asset, '.') + 1);

				if($extension == 'js')
				{
					$GLOBALS['TL_JAVASCRIPT'][] = $asset . '|static';
				} else
				{
					$GLOBALS['TL_CSS'][] = $asset . '|static';
				}
			}
		}
	}


	/**
	 * add bootstrap form widget as delegator by using the loadFormField hook
	 *
	 * @param \Widget $widget
	 * @param         $formId
	 * @param         $data
	 * @param         $form
	 *
	 * @return BootstrapWidget|\Widget
	 */
	public function initializeFormWidget(\Widget $widget, $formId, $data, $form)
	{
		$layout = self::getPageLayout();

		if($layout->addBootstrap)
		{
			return new BootstrapWidget($widget);
		}

		return $widget;
	}


	/**
	 * get current layout of current page
	 *
	 * @return \LayoutModel|\Model|null
	 */
	protected static function getPageLayout()
	{
		if(self::$pageLayout === null)
		{
			global $objPage;
			self::$pageLayout = \LayoutModel::findByPk($objPage->layout);
		}

		return self::$pageLayout;
	}


	/**
	 * get all templates. A templatePrefix can be defined using eval.TemplatePrefix
	 *
	 * @param $dc
	 *
	 * @return array
	 */
	public function getTemplates($dc)
	{
		if(isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix']))
		{
			return \TemplateLoader::getPrefixedFiles($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix']);
		}

		return \TemplateLoader::getFiles();
	}


	/**
	 * execute all registered template modifiers
	 *
	 * @param \Template $template
	 */
	public function callTemplateModifiers(\Template $template)
	{
		if(!static::getPageLayout()->addBootstrap)
		{
			return;
		}

		foreach($GLOBALS['BOOTSTRAP']['templates']['modifiers'] as $config)
		{
			if(!in_array($template->getName(), $config['templates']))
			{
				continue;
			}

			if($config['type'] == 'placeholder')
			{
				if(is_callable($config['value']))
				{
					$value = call_user_func($config['value'], $template);
				}
				else
				{
					$value = $config['value'];
				}

				$template->$config['key'] = str_replace($config['placeholder'], $value, $template->$config['key']);
			}
			elseif($config['type'] == 'callback')
			{
				call_user_func($config['callback'], $template);
			}
		}
	}

}