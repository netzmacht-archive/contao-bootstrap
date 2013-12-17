<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   iconWizard
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
 */

if(!defined('TL_MODE')) {
	define('TL_MODE', 'BE');
}

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/system/initialize.php';

/**
 * Initialize the system
 */

$controller = new Netzmacht\Bootstrap\Installer();
$controller->run();