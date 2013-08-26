<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Bootstrap
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Netzmacht',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Netzmacht\Bootstrap\Icons'                    => 'system/modules/bootstrap/classes/Icons.php',
	'Netzmacht\Bootstrap\Installer'                => 'system/modules/bootstrap/classes/Installer.php',
	'Pagination'                                   => 'system/modules/bootstrap/classes/Pagination.php',

	// DataContainer
	'Netzmacht\Bootstrap\DataContainer\Bootstrap'  => 'system/modules/bootstrap/dataContainer/Bootstrap.php',
	'Netzmacht\Bootstrap\DataContainer\Content'    => 'system/modules/bootstrap/dataContainer/Content.php',
	'Netzmacht\Bootstrap\DataContainer\StylePicker' => 'system/modules/bootstrap/dataContainer/StylePicker.php',

	// Modules
	'Netzmacht\Bootstrap\BootstrapModule'          => 'system/modules/bootstrap/modules/BootstrapModule.php',
	'Netzmacht\Bootstrap\ModuleNavbar'             => 'system/modules/bootstrap/modules/ModuleNavbar.php',

	// Elements
	'Netzmacht\Bootstrap\BootstrapContentElement'  => 'system/modules/bootstrap/elements/BootstrapContentElement.php',
	'Netzmacht\Bootstrap\ContentButton'            => 'system/modules/bootstrap/elements/ContentButton.php',
	'Netzmacht\Bootstrap\ContentColumnSet'         => 'system/modules/bootstrap/elements/ContentColumnSet.php',
	'Netzmacht\Bootstrap\ContentSlider'            => 'system/modules/bootstrap/elements/ContentSlider.php',

	// Forms
	//'Netzmacht\Bootstrap\FormCheckBox'             => 'system/modules/bootstrap/forms/FormCheckBox.php',
	'Netzmacht\Bootstrap\BootstrapWidget'          => 'system/modules/bootstrap/forms/BootstrapWidget.php',
	'Netzmacht\Bootstrap\FormButton'               => 'system/modules/bootstrap/forms/FormButton.php',
	//'Netzmacht\Bootstrap\FormInputGroup'           => 'system/modules/bootstrap/forms/FormInputGroup.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_bootstrap_button'    => 'system/modules/bootstrap/templates',
	'ce_bootstrap_columnset' => 'system/modules/bootstrap/templates',
	'ce_bootstrap_slider'    => 'system/modules/bootstrap/templates',
	'mod_navbar'             => 'system/modules/bootstrap/templates',
	'mod_navbar_container'   => 'system/modules/bootstrap/templates',
	'mod_search_advanced'    => 'system/modules/bootstrap/templates',
	'nav_bootstrap_dropdown' => 'system/modules/bootstrap/templates',
	'navbar'                 => 'system/modules/bootstrap/templates',
	'navbar_brand'           => 'system/modules/bootstrap/templates',
	'navbar_toggle'          => 'system/modules/bootstrap/templates',
	'form_checkbox_generate' => 'system/modules/bootstrap/templates',
	'form_radio_generate'    => 'system/modules/bootstrap/templates',
	'pagination'             => 'system/modules/bootstrap/templates',
));