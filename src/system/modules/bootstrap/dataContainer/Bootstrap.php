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

/**
 * Class BootstrapDataContainer
 * @package Netzmacht\Bootstrap
 */
class Bootstrap
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
		$model = \ModuleModel::findAll(array('order' => 'name'));
		$modules = array(
			'bootstrap' => \TemplateLoader::getPrefixedFiles('navbar_'),
			'modules' => array(),
		);

		if($model === null) {
			return $modules;
		}

		while($model->next()) {
			$modules['modules'][$model->id] = $model->name;
		}

		return $modules;
	}


	/**
	 * only load templates if bootstrap is activated, so diverent layouts will work instead of template changes
	 * @param $objTemplate
	 */
	public function initializeLayout($objTemplate)
	{
		global $objPage;

		if(static::$bootstrapLoaded || !$objPage) {
			return;
		}

		static::$bootstrapLoaded = true;

		$layout = self::getPageLayout();

		if($layout->addBootstrap)
		{
			// only load these templates if layout uses it because default templates are changed
			foreach($GLOBALS['BOOTSTRAP']['dynamicLoadTemplates'] as $path => $templates)
			{
				foreach($templates as $template)
				{
					\TemplateLoader::addFile($template, $path);
				}
			}

			// load assets
			$layout->bootstrapAssets = deserialize($layout->bootstrapAssets, true);

			foreach($layout->bootstrapAssets as $asset) {
				$extension = substr($asset, strrpos($asset, '.') +1);

				if($extension == 'js') {
					$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/bootstrap/assets/bootstrap/' . $asset . '|static';
				}
				else {
					$GLOBALS['TL_CSS'][] = 'system/modules/bootstrap/assets/bootstrap/' . $asset . '|static';
				}
			}
		}
	}

	public function initializeFormWidget(\Widget $widget, $formId, $data, $form)
	{
		$layout = self::getPageLayout();

		if($layout->addBootstrap) {
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

}