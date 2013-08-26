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

use \FrontendTemplate;


/**
 * Class ModuleNavbar
 *
 * @package Netzmacht\Bootstrap
 */
class ModuleNavbar extends BootstrapModule
{

	/**
	 * list of bootstrap attributes to easily access it without namespace
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('addHeader', 'isResponsive', 'navbarModules', 'navbarTemplate');

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
		parent::compile();

		// generate modules
		$dataModules = deserialize($this->navbarModules, true);
		$modules = array();

		foreach ($dataModules as $module)
		{
			$modules[] = $this->generateModule($module);
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

		return array(
			'type'   => 'module',
			'module' => $this->getFrontendModule($module['module']),
			'id'     => $module['module'],
			'class'  => $class,
		);
	}

}