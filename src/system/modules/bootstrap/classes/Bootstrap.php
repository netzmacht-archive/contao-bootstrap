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
 * Class Bootstrap is used for setting up Bootstrap usage
 * @package Netzmacht\Bootstrap
 */
class Bootstrap
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

		if(!$layout->addBootstrap)
		{
			return;
		}

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
		if(static::isEnabled())
		{
			return new BootstrapWidget($widget);
		}

		return $widget;
	}


	/**
	 * check if bootstrap is used
	 *
	 * @return bool
	 */
	public static function isEnabled()
	{
		if(static::getPageLayout() === null)
		{
			return false;
		}

		return (bool) static::getPageLayout()->addBootstrap;
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

}