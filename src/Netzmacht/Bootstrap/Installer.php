<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 26.08.13
 * Time: 08:36
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


/**
 * Class Installer
 * @package Netzmacht\Bootstrap
 */
class Installer extends \Backend
{

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		$this->import('Database');

		parent::__construct();

		$this->User->authenticate();

		$this->loadLanguageFile('default');
		$this->loadLanguageFile('modules');
	}


	/**
	 * method for runonce.php
	 */
	public function runOnce()
	{
		if($this->User->isAdmin)
		{
			$this->setupSections();
		}
	}


	/**
	 * setup required sections
	 */
	protected function setupSections()
	{
		if($GLOBALS['TL_CONFIG']['customSections'] == '') {
			$GLOBALS['TL_CONFIG']['customSections'] = 'bootstrap';
		}
		elseif(strpos($GLOBALS['TL_CONFIG']['customSections'], 'bootstrap') === false) {
			$GLOBALS['TL_CONFIG']['customSections'] .= ',bootstrap';
		}

		$config = \Config::getInstance();
		$config->add('$GLOBALS[\'TL_CONFIG\'][\'customSections\']', $GLOBALS['TL_CONFIG']['customSections']);
		$config->save();
	}


	/**
	 * check if file is in one of the defined paths
	 * @param $fileName
	 * @param $paths
	 *
	 * @return bool
	 */
	protected function fileMatchPaths($fileName, $paths)
	{
		foreach($paths as $path)
		{
			if(strpos($fileName, $path) === 0)
			{
				return true;
			}
		}

		return false;
	}
}