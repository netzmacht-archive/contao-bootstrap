<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package   netzmacht-columnset
 * @author    David Molineus <http://www.netzmacht.de>
 * @license   GNU/LGPL
 * @copyright Copyright 2012 David Molineus netzmacht creative
 *
 **/

$GLOBALS['BOOTSTRAP']['templates'] = array

(
	// Define paths for autoloading templates. This is used so that only if bootstrap is activated in the layout
	// the default templates are overridden
	// You can add different template directories here.
	'dynamicLoad' => array
	(
		'system/modules/bootstrap/templates/theme' => array
		(
			'ce_accordion',
			'ce_accordion_start',
			'form',
			'formhelper_element_checkboxes',
			'formhelper_element_radios',
			'mod_breadcrumb',
			'mod_comment_form',
			'mod_search_advanced',
			'mod_quicklink',
			'mod_quicknav',
			'nav_default',
			'pagination',
		),
	),

	// Configuration of template modifiers. They changes templates when being parsed. There are 2 types supported:
	// placeholder or callback. A placeholder try to replace a string of an template variable. A Callback just
	// runs before template is rendered. It's pretty the same like the parseTemplate hook but, you can specify
	// which templates are affected and use anonymous functions
	'modifiers' => array
	(
		// add active class to trail class
		'callback.addActiveClassToTrailItem' => array
		(
			'type'      => 'callback',
			'callback'  => array('Netzmacht\Bootstrap\Template\Modifier\Navigation', 'addActiveClassToTrailItem'),
			'templates' => array
			(
				'nav_default*',
				'nav_bootstrap_dropdown*',
			),
		),

		'replace.paginationActiveClass' => array
		(
			'type'        => 'replace',
			'key'         => 'items',
			'search'      => '<li><span class="current">',
			'replace'     => '<li class="active"><span>',
			'templates'   => array('pagination'),
		),

		'callback.setPanelDefaultClass' => array
		(
			'type'      => 'callback',
			'callback'  => array('Netzmacht\Bootstrap\Template\Modifier\Panel', 'setPanelDefaultClass'),
			'templates' => array
			(
				'ce_accordion',
				'ce_accordion_start',
			),
		),

		'callback.setNavigationLevel' => array
		(
			'type'      => 'callback',
			'callback'  => array('Netzmacht\Bootstrap\Template\Modifier\Navigation', 'setNavigationLevel'),
			'templates' => array
			(
				'nav_bootstrap_dropdown*',
			),

		),

		// #navClass# placeholder is used for injecting defined nav classes to the rendered items
		'replace.replaceNavClassPlaceholder' => array
		(
			'type'      => 'replace',
			'key'       => 'items',
			'search'    => '__navClass__',
			'replace'   => array('Netzmacht\Bootstrap\Template\Modifier\Navigation', 'replaceNavClassPlaceholder'),
			'templates' => array
			(
				'mod_navigation*',
				'mod_customnav*',
			),
		),

		'callback.initializeFePage' => array
		(
			'type'      => 'callback',
			'callback'  => array('Netzmacht\Bootstrap\Template\Modifier\Layout', 'initialize'),
			'templates' => array
			(
				'fe_*',
			),
		),
	),

	// Configuration of template parsers. They changes already parsed templates. There are 2 types supported:
	// placeholder or callback. A placeholder try to replace a string of an template variable. A Callback just
	// runs before template is rendered. It's pretty the same like the parseTemplate hook but, you can specify
	// which templates are affected and use anonymous functions
	'parsers' => array
	(
		'callback.replaceClasses' => array
		(
			'type'      => 'callback',
			'callback'  => array('Netzmacht\Bootstrap\Template\Modifier\Layout', 'replaceClasses'),
			'templates' => array
			(
				'fe_*',
			),
		),
	),
);