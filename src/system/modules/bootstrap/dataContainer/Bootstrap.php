<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 12.08.13
 * Time: 20:34
 * To change this template use File | Settings | File Templates.
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
	 * @var
	 */
	protected static $pageLayout;


	/**
	 * @param $mcw
	 * @return array
	 */
	public function getAllModules($mcw)
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
	 * @param $objTemplate
	 */
	public function initializeLayoutByParseTemplateHook($objTemplate)
	{
		global $objPage;

		if(static::$bootstrapLoaded || !$objPage)
		{
			return;
		}

		static::$bootstrapLoaded = true;

		$layout = self::getPageLayout();

		$this->initializeLayout($objPage, $layout);
	}


	/**
	 * only load templates if bootstrap is activated, so diverent layouts will work instead of template changes
	 *
	 * @param $objTemplate
	 */
	public function initializeLayout($page, $layout)
	{
		static::$pageLayout = $layout;

		if($layout->addBootstrap)
		{
			// only load these templates if layout uses it because default templates are changed
			foreach ($GLOBALS['BOOTSTRAP']['dynamicLoadTemplates'] as $path => $templates)
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
					$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/bootstrap/assets/bootstrap/' . $asset . '|static';
				} else
				{
					$GLOBALS['TL_CSS'][] = 'system/modules/bootstrap/assets/bootstrap/' . $asset . '|static';
				}
			}
		}
	}


	public function initializeFormWidget(\Widget $widget, $formId, $data, $form)
	{
		$layout = self::getPageLayout();

		if($layout->addBootstrap)
		{
			return new BootstrapWidget($widget);
		}

		return $widget;
	}


	protected static function getPageLayout()
	{
		if(self::$pageLayout === null)
		{
			global $objPage;
			self::$pageLayout = \LayoutModel::findByPk($objPage->layout);
		}

		return self::$pageLayout;
	}


	public function getTemplates($dc)
	{
		if(isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix']))
		{
			return \TemplateLoader::getPrefixedFiles($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix']);
		}

		return \TemplateLoader::getFiles();

	}

}