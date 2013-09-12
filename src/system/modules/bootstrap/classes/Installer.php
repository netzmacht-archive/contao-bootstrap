<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 26.08.13
 * Time: 08:36
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


class Installer extends \Backend
{
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		$this->import('Database');
		parent::__construct();

		$this->User->authenticate();

		$this->loadLanguageFile('default');
		$this->loadLanguageFile('modules');
	}

	public function runOnce()
	{
		if(!$this->User->isAdmin) {
			return;
		}

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

}