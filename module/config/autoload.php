<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Bootstrap
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_bootstrap_button'    => 'system/modules/bootstrap/templates/elements',
	'ce_bootstrap_buttons'   => 'system/modules/bootstrap/templates/elements',
	'ce_bootstrap_carousel'  => 'system/modules/bootstrap/templates/elements',
	'ce_bootstrap_columnset' => 'system/modules/bootstrap/templates/elements',
	'ce_accordion_group'     => 'system/modules/bootstrap/templates/elements',
	'ce_bootstrap_tab'       => 'system/modules/bootstrap/templates/elements',

	'mod_navbar'             => 'system/modules/bootstrap/templates/modules',
	'mod_navbar_container'   => 'system/modules/bootstrap/templates/modules',
	'mod_bootstrap_modal'    => 'system/modules/bootstrap/templates/modules',

	'form_radio_generate'    => 'system/modules/bootstrap/templates/form',
	'form_checkbox_generate' => 'system/modules/bootstrap/templates/form',
	'formhelper_layout_bootstrap' => 'system/modules/bootstrap/templates/form',

	'navbar'                 => 'system/modules/bootstrap/templates/navigation',
	'navbar_brand'           => 'system/modules/bootstrap/templates/navigation',
	'navbar_toggle'          => 'system/modules/bootstrap/templates/navigation',
	'nav_bootstrap_dropdown' => 'system/modules/bootstrap/templates/navigation',

	'gallery_grid'           => 'system/modules/bootstrap/templates/gallery',
	'gallery_carousel'       => 'system/modules/bootstrap/templates/gallery',

	'bootstrap_buttons_item' => 'system/modules/bootstrap/templates',
	'bootstrap_buttons'      => 'system/modules/bootstrap/templates',
	'com_bootstrap'          => 'system/modules/bootstrap/templates',
	'fe_bootstrap'           => 'system/modules/bootstrap/templates',
));
