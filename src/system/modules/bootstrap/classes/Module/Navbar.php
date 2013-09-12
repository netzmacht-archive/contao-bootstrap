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

namespace Netzmacht\Bootstrap\Module;


use Contao\ModuleModel;
use \FrontendTemplate;


/**
 * Class ModuleNavbar
 *
 * @package Netzmacht\Bootstrap
 */
class Navbar extends BootstrapAbstract
{

	/**
	 * list of bootstrap attributes to easily access it without namespace
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('addHeader', 'isResponsive', 'navbarModules', 'navbarTemplate', 'navbarBrandTemplate');

	/**
	 * @var string
	 */
	protected $strTemplate = 'mod_navbar';


	/**
	 * @param        $module
	 * @param string $column
	 */
	public function __construct($module, $column='main')
	{
		parent::__construct($module, $column);

		if($this->navbarTemplate != '') {
			$this->strTemplate = $this->navbarTemplate;
		}
	}


	/**
	 * compile the navbar
	 */
	protected function compile()
	{
		// generate modules
		$dataModules = deserialize($this->navbarModules, true);
		$modules = array();

		foreach ($dataModules as $module)
		{
			if($module['module'] != '')
			{
				$modules[] = $this->generateModule($module);
			}
		}

		if($this->cssID[1] == '')
		{
			$cssID = $this->cssID;
			$cssID[1] = 'navbar-default';
			$this->cssID = $cssID;
		}

		$this->Template->modules = $modules;
	}


	/**
	 * @param $module
	 * @return array
	 */
	protected function generateModule($module)
	{
		$class = $module['cssClass'];

		if($module['floating'])
		{
			if($class != '') {
				$class .= ' ';
			}

			$class .= 'navbar-' . $module['floating'];
		}

		$model = ModuleModel::findByPk($module['module']);
		$model->bootstrap_inNavbar = true;
		$model->bootstrap_navbarFloating = $module['floating'];

		$rendered = $this->getFrontendModule($model);

		return array(
			'type'   => 'module',
			'module' => $rendered,
			'id'     => $module['module'],
			'class'  => $class,
		);
	}

}