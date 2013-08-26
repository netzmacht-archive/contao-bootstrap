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


/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_module']['metapalettes']['bootstrap_navbar'] = array
(
	'title'                     => array('name', 'type'),
	'config'                    => array('bootstrap_navigation', 'bootstrap_isResponsive', 'bootstrap_addHeader', 'bootstrap_navbarModules'),
	'protected'                 => array(':hide', 'protected'),
	'expert'                    => array(':hide', 'guests', 'cssID', 'space'),
	'template'                  => array(':hide', 'bootstrap_navbarTemplate'),
);


/**
 * fields
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_isResponsive'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_isResponsive'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => true,
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_addHeader'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_addHeader'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarModules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'tl_class' => '" style="clear:both;',
		'columnFields' => array
		(
			'module' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_module'],
				'inputType' => 'select',
				'options_callback' => array('Bootstrap\\DataContainer\\Bootstrap', 'getAllModules'),
				'eval' => array('style' => 'width: 300px', 'includeBlankOption' => true, 'chosen' => true),
			),

			'floating' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_floating'],
				'inputType' => 'select',
				'options' => array('left', 'right'),
				'reference' => &$GLOBALS['TL_LANG']['MSC'],
				'eval' => array('style' => 'width: 80px', 'includeBlankOption' => true),
			),

			'cssClass' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_cssClass'],
				'inputType' => 'text',
				'eval' => array('style' => 'width: 200px', 'rgxp' => 'txt'),
			),
		)
	),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarTemplate'],
	'default'                 => 'mod_navbar',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('Bootstrap\\DataContainer\\Bootstrap', 'getTemplates'),
	'eval'                    => array('templatePrefix' => 'mod_navbar'),
	'sql'                     => "varchar(32) NOT NULL default ''",
);