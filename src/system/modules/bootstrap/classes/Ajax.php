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
 * Class Ajax stores methods registered to the simpleAjax hook
 * @package Netzmacht\Bootstrap
 */
class Ajax extends \PageRegular
{

	/**
	 * load language file
	 */
	public function __construct()
	{
		parent::__construct();

		// required for form captcha
		$this->loadLanguageFile('default');
	}


	/**
	 * load modal content
	 */
	public function loadModalContent()
	{
		global $objPage;

		$id = \Input::get('modal');

		if($id == '')
		{
			return;
		}

		$page = \Input::get('page');

		// load layout because we need to initiate bootstrap
		$objPage = \Frontend::getPageDetails($page);
		$objLayout = $this->getPageLayout($objPage);

		// HOOK: modify the page or layout object (see #4736)
		if (isset($GLOBALS['TL_HOOKS']['getPageLayout']) && is_array($GLOBALS['TL_HOOKS']['getPageLayout']))
		{
			foreach ($GLOBALS['TL_HOOKS']['getPageLayout'] as $callback)
			{
				$this->import($callback[0]);
				$this->$callback[0]->$callback[1]($objPage, $objLayout, $this);
			}
		}

		$model = \ModuleModel::findOneBy('type="bootstrap_modal" AND tl_module.id', $id);

		if($model === null)
		{
			return;
		}

		$model->isAjax = true;
		$this->output($this->getFrontendModule($model));
	}


	/**
	 * Output data, encode to json and replace insert tags
	 * @param  mixed
	 * @return string
	 */
	protected function output($value)
	{
		$value = $this->replaceInsertTags($value);

		if (is_array($value) || is_object($value))
		{
			$value = json_encode($value);
		}

		echo $value;
		exit;
	}
}