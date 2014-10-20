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
     * @return string
     */
    public function generate()
    {
        if(TL_MODE == 'BE') {
            $template = new \BackendTemplate('be_wildcard');

            $template->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['bootstrap_navbar'][0]) . ' ###';
            $template->title = $this->name;
            $template->id = $this->id;
            $template->link = $this->name;
            $template->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $template->parse();
        }

        return parent::generate();
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