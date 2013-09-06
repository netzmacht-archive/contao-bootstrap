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
$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('Bootstrap\\ContentDataContainer', 'setArticlesRows');
$GLOBALS['TL_DCA']['tl_content']['config']['ondelete_callback'][] = array('Bootstrap\\WrapperDataContainer', 'delete');

/**
 * palettes
 */

// add bootstrap_subType to the selectors
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'bootstrap_subType';

// define default bootstrap palette
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['_bootstrap_'] = array
(
	'type' => array('type', 'headline'),
	'link' => array(),
	'config' => array(),
	'protected' => array(':hide', 'protected'),
	'expert' => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);

// bootstrap contentSlider palettes
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['_typeOnly_'] = array
(
	'type' => array('type'),
);

// bootstrap_button palette
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_button extends _typeOnly_'] = array
(
	'link'   => array('url', 'target', 'linkTitle', 'titleText', 'rel', 'bootstrap_icon', 'bootstrap_dataAttributes'),
	'expert' => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);


// bootstrap carousel
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_carouselPart extends _typeOnly_'] = array();
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_carouselEnd extends _typeOnly_'] = array();

$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_carouselStart extends _typeOnly_'] = array
(
	'config' => array(
		'bootstrap_showIndicators',
		'bootstrap_showControls',
		'bootstrap_autostart',
		'bootstrap_interval',
	),
	'expert' => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);


// bootstrap tabs palette
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_tabPart extends _typeOnly_'] = array();
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_tabEnd extends _typeOnly_'] = array();

$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_tabStart extends _typeOnly_'] = array
(
	'config' => array(
		'bootstrap_tabs', 'bootstrap_fade',
	),
	'expert' => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);

// boostrap columnset palettes
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_columnset extends _bootstrap_'] = array
(
	'config' => array('sc_type', 'bootstrap_articleMarkup'),
);

$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_buttons extends _bootstrap_'] = array
(
	'config' => array('bootstrap_buttons', 'bootstrap_buttonStyle'),
);


/**
 * sub select palettes
 */
$GLOBALS['TL_DCA']['tl_content']['metasubselectpalettes']['sc_type']['!'] = array('bootstrap_columnset');


/**
 * fields
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['type']['save_callback'][] = array('Bootstrap\\WrapperDataContainer', 'save');

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_articleMarkup'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_articleMarkup'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50','style' => 'clear: both;',),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttonStyle'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttonStyle'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'                    => array('tl_class' => 'w50', ),
	'sql'                     => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_icon'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_icon'],
	'exclude'                 => true,
	'inputType'               => 'icon',
	'options'                 => Bootstrap\Icons::getIcons(),
	'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true, 'iconTemplate' => Bootstrap\Icons::getIconTemplate()),
	'sql'                     => "varchar(32) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_columnset'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_columnset'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'columnFields' => array
		(
			'article' => array
			(
				'label'                 => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_columnset_article'],
				'exclude'               => true,
				'inputType'             => 'select',
				'options_callback'     	=> array('Bootstrap\\ContentDataContainer', 'getPageBootstrapArticles'),
				'eval' 			=> array('style' => 'width:450px', 'includeBlankOption'=>true, 'chosen'=>true)
			),
		),
		'buttons'  => array('copy' => false, 'delete' => false),
		'tl_class' => '" style="clear:both;', /* workaround for Contao #6093 */

	),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_showIndicators'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_showIndicators'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'m12 w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_showControls'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_showControls'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_autostart'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_autostart'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_interval'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_interval'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'clr'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_subType'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_subType'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options'                 => array('start', 'part', 'end'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_subType'],
	'eval'                    => array('tl_class'=>'clr', 'submitOnChange' => true),
	'sql'                     => "varchar(5) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_tabs'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'tl_class'=>'clr',
		'submitOnChange' => true,
		'columnFields' => array
		(
			'title' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs_title'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array(),
			),
			'type' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs_type'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'options'                 => array('dropdown', 'child'),
				'reference'               => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_tabs_type'],
				'eval'                    => array('includeBlankOption' => true, 'style' => 'width: 140px;'),
			),
		)
	),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_fade'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_fade'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_parentId'] = array
(
	'sql'                     => "int(10) unsigned NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttons'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'tl_class'=>'clr',
		'helpwizard' => true,
		'submitOnChange' => true,
		'columnFields' => array
		(
			'type' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_type'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'options'                 => array('link', 'group', 'dropdown', 'child', 'header'),
				'reference'               => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_types'],
				'eval'                    => array('style' => 'width: 95px;'),
			),

			'label' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_label'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array('style' => 'width: 170px'),
			),

			'url' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_url'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array('style' => 'width: 100px', 'rgxp' => 'url', 'decodeEntities'=>true, 'tl_class' => 'wizard'),
				'wizard' => array
				(
					array('Bootstrap\\GeneralDataContainer', 'pagePicker')
				),
			),

			'attributes' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_attributes'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array('style' => 'width: 200px', 'decodeEntities' => true),
			),
		)
	),
	'sql' => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_dataAttributes'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_dataAttributes'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'tl_class'=>'clr',
		'columnFields' => array
		(
			'name' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_dataAttributes_name'],
				'exclude'                 => true,
				// @todo 'customselect' waiting for PR integrated https://github.com/xat/contao-customselectmenu/pull/5
				'inputType'               => 'select',
				'options'                 => $GLOBALS['BOOTSTRAP']['button']['dataAttributes'],
				'reference'               => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_types'],
				'eval'                    => array('style' => 'width: 75px;', 'includeBlankOption' => true),
			),

			'value' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_dataAttributes_value'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array('style' => 'width: 160px'),
			),
		)
	),
	'sql' => "blob NULL"
);