<?php

/**
 * config
 */
$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('Bootstrap\\DataContainer\\Content', 'setArticlesRows');


/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['__bootstrap__'] = array
(
	'type' => array('type', 'headline'),
	'link' => array(),
	'config' => array(),
	'protected' => array(':hide', 'protected'),
	'expert' => array(':hide', 'guests', 'cssID', 'space'),
	'invisible' => array(':hide', 'invisible', 'start', 'stop'),
);

$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_button extends __bootstrap__'] = array
(
	'link'   => array('url', 'target', 'linkTitle', 'embed', 'titleText', 'rel'),
	'config' => array('bootstrap_buttonType', 'bootstrap_buttonSize', 'bootstrap_icon', 'bootstrap_buttonDisabled'),
);

$GLOBALS['TL_DCA']['tl_content']['metapalettes']['bootstrap_columnset extends __bootstrap__'] = array
(
	'config' => array('sc_type', 'bootstrap_articleMarkup'),
);

$GLOBALS['TL_DCA']['tl_content']['metasubselectpalettes']['sc_type']['!'] = array('bootstrap_columnset');


/**
 * fields
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_articleMarkup'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_articleMarkup'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50','style' => 'clear: both;',),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttonType'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttonType'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('default', 'primary', 'sucess', 'info', 'warning', 'danger', 'link'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttonSize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttonType'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('default', 'btn-lg', 'btn-sm', 'btn-xs'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'                    => array('tl_class' => 'w50', ),
	'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_icon'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_icon'],
	'exclude'                 => true,
	'inputType'               => 'icon',
	'options'                 => $GLOBALS['BOOTSTRAP']['icons']['set'],
	'reference'               => &$GLOBALS['TL_LANG']['tl_content'],
	'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true),
	'sql'                     => "varchar(32) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_buttonDisabled'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttonDisabled'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12'),
	'sql'                     => "char(1) NOT NULL default ''"
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
				'options_callback'     	=> array('Bootstrap\\DataContainer\\Content', 'getPageBootstrapArticles'),
				'eval' 			=> array('style' => 'width:450px', 'includeBlankOption'=>true, 'chosen'=>true)
			),
		),
		'buttons'  => array('copy' => false, 'delete' => false),
		'tl_class' => '" style="clear:both;', /* workaround for Contao #6093 */

	),
	'sql'                     => "blob NULL"
);