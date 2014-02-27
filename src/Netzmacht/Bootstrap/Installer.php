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
	public function run()
	{
		\Controller::log('Bootstrap installer called', '\Netzmacht\Bootstrap::run', TL_INFO);

		$this->setupSections();
		$this->createSymlink();

		\Controller::log('Bootstrap installer finished', '\Netzmacht\Bootstrap::run', TL_INFO);
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
	 * Create symlink
	 */
	protected function createSymlink()
	{
		$target  = TL_ROOT . '/composer/vendor/twbs/bootstrap';
		$link    = TL_ROOT . '/assets/bootstrap/bootstrap';
		$dir     = TL_ROOT . '/assets/bootstrap';

		$success = false;

		// dir or link already exists
		if(is_dir($link) || is_link($link)) {
			return;
		}

		// create parent dir
		if(!is_dir($dir)) {
			mkdir($dir);
		}

		if(is_dir($target)) {
			$success = symlink($target, $link);
		}

		if(!$success) {
			\Controller::log("Error during creating symlink '$target'", 'Netzmacht\Bootstrap\Installer createSymlink', TL_ERROR);
		}
		else {
			\Controller::log("Created symlink '$target'", 'Netzmacht\Bootstrap\Installer createSymlink', TL_INFO);
		}
	}

}
