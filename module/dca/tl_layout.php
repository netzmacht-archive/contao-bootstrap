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
 * config
 */
$GLOBALS['TL_DCA']['tl_layout']['config']['palettes_callback'][]   = array('Netzmacht\Bootstrap\DataContainer\Layout', 'generatePalette');


/**
 * subpalettes
 */
$GLOBALS['TL_DCA']['tl_layout']['metasubpalettes']['bootstrap_importJavaScripts'] = array('bootstrap_javaScripts');
$GLOBALS['TL_DCA']['tl_layout']['metasubpalettes']['bootstrap_importStylesheets'] = array('bootstrap_stylesheets');


/**
 * fields
 */
$GLOBALS['TL_DCA']['tl_layout']['fields']['name']['eval']['tl_class'] = 'w50';

// use template loader which shows list of safe and unsafe templates
$GLOBALS['TL_DCA']['tl_layout']['fields']['template']['reference'] = $GLOBALS['TL_LANG']['tl_layout'];
$GLOBALS['TL_DCA']['tl_layout']['fields']['template']['options_callback'] = array('Netzmacht\Bootstrap\DataContainer\Layout', 'getTemplates');
$GLOBALS['TL_DCA']['tl_layout']['fields']['template']['eval'] = array('templatePrefix' => 'fe_', 'templateThemeId' => 'pid');

// do not import layout builder by default to prevent side effects
$GLOBALS['TL_DCA']['tl_layout']['fields']['framework']['default'] = array();

$GLOBALS['TL_DCA']['tl_layout']['fields']['layoutType'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['layoutType'],
	'default'                 => 'default',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('default', 'bootstrap'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_layout']['layoutTypes'],
	'eval'                    => array('tl_class' => 'w50', 'submitOnChange' => true, 'helpwizard'=>true,),
	'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_headerClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_headerClass'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_footerClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_footerClass'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_mainClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_mainClass'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_leftClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_leftClass'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_rightClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_rightClass'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_importStylesheets'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_importStylesheets'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange' => true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_stylesheets'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_stylesheets'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'options'                 => $GLOBALS['BOOTSTRAP']['assets']['css'],
	'save_callback'           => array(
		array('Netzmacht\Bootstrap\DataContainer\Layout', 'installStylesheets'),
	),
	'eval'                    => array
	(
		'columnFields' => array
		(
			'file' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_importFile'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Layout', 'getStylesheets'),
				'eval'                    => array('style' => 'width: 300px'),
			),

			'conditional' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_conditional'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array('style' => 'width: 140px'),
			),

			'asseticFilter' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_asseticFilter'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'reference'               => &$GLOBALS['TL_LANG']['assetic'],
				'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Layout', 'getCssAsseticFilterOptions'),
				'eval'                    => array('style' => 'width: 140px', 'includeBlankOption' => true),
			),

		),

		''
	),
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_importJavaScripts'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_importJavaScripts'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange' => true),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_javaScripts'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_javaScripts'],
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_javaScripts'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'options'                 => $GLOBALS['BOOTSTRAP']['assets']['js'],
	'save_callback'           => array(
		array('Netzmacht\Bootstrap\DataContainer\Layout', 'installJavaScripts'),
	),
	'eval'                    => array
	(
		'columnFields' => array
		(
			'file' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_importFile'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Layout', 'getJavaScripts'),
				'eval'                    => array('style' => 'width: 300px'),
			),

			'conditional' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_conditional'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'options'                 => array('lt IE 9'),
				'eval'                    => array('style' => 'width: 140px', 'includeBlankOption' => true),
			),

			'asseticFilter' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_asseticFilter'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'reference'               => &$GLOBALS['TL_LANG']['assetic'],
				'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Layout', 'getJsAsseticFilterOptions'),
				'eval'                    => array('style' => 'width: 140px', 'includeBlankOption' => true),
			),

		),

		''
	),
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['viewport'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['viewport'],
	'exclude'                 => true,
	'default'                 => $GLOBALS['BOOTSTRAP']['layout']['viewport'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class' => 'w50', 'decodeEntities' => true),
	'sql'                     => "varchar(255) NOT NULL default ''",
);

