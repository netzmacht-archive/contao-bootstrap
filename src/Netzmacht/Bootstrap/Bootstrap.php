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
	 * only load templates if bootstrap is activated, so diverent layouts will work instead of template changes
	 *
	 * @param \PageModel   $page
	 * @param \LayoutModel $layout
	 */
	public function initializeLayout($page, \LayoutModel $layout)
	{
		static::$pageLayout = $layout;

		if(!static::isEnabled())
		{
			return;
		}

		// reset default framework
		static::$pageLayout->framework = null;

		$templates = $GLOBALS['BOOTSTRAP']['templates']['dynamicLoad'];

		// only load these templates if layout uses it because default templates are changed
		foreach ($templates as $path => $templates)
		{
			foreach ($templates as $template)
			{
				\TemplateLoader::addFile($template, $path);
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
			return new Form\Widget($widget);
		}

		return $widget;
	}


	/**
	 * initialize user config, load it here so it affect other extensions as well
	 */
	public function initializeConfig()
	{
		if($GLOBALS['TL_CONFIG']['bootstrapIconSet']) {
			$GLOBALS['BOOTSTRAP']['icons']['active'] = $GLOBALS['TL_CONFIG']['bootstrapIconSet'];
		}
	}


	/**
	 * check if bootstrap is used
	 *
	 * @return bool
	 */
	public static function isEnabled()
	{
		if(static::getLayout() === null)
		{
			return false;
		}

		return (bool) (static::$pageLayout->layoutType == 'bootstrap');
	}


	/**
	 * get current layout of current page
	 *
	 * @return \LayoutModel|\Model|null
	 */
	public static function getLayout()
	{
		if(self::$pageLayout === null)
		{
			global $objPage;

			if($objPage !== null)
			{
				self::$pageLayout = \LayoutModel::findByPk($objPage->layout);
			}
		}

		return self::$pageLayout;
	}
}