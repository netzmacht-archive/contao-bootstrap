<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 12.08.13
 * Time: 20:31
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


use Contao\FrontendTemplate;

class ModuleNavbar extends \Module
{
	protected $strTemplate = 'mod_bootstrap_navbar';

	protected function compile()
	{
		$dataModules = deserialize($this->bootstrap_navbarModules, true);
		$dataHeader = deserialize($this->bootstrap_navbarHeader, true);

		$modules = array();
		$header = array();

		foreach($dataModules as $module) {
			$modules[] = $this->generateModule($module);
		}

		foreach($dataHeader as $module) {
			$header[] = $this->generateModule($module);
		}

		$this->Template->modules = $modules;
		$this->Template->header = $header;
	}

	protected function generateModule($module)
	{
		$class = '';

		if($module['floating']) {
			$class = 'pull-' . $module['floating'] . ' ';
		}

		$class .= $module['cssClass'];

		if(intval($module['module'])) {
			$rendered = $this->getFrontendModule($module['module']);

			return array(
				'type' => 'module',
				'module' => $rendered,
				'id' => $module['module'],
				'class' => $class,
			);
		}

		$template = new FrontendTemplate($module['module']);

		return array(
			'type' => 'template',
			'module' => $template->parse(),
			'id' => $module['module'],
			'class' => $class,
		);
	}

}