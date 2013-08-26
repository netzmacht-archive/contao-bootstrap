<?php

$GLOBALS['TL_DCA']['tl_module']['metapalettes']['bootstrap_navbar'] = array
(
	'title'                     => array('name', 'type'),
	'config'                   => array('bootstrap_navbarHeader', 'bootstrap_navbarModules'),
	'protected'                 => array(':hide', 'protected'),
	'expert'                    => array(':hide', 'guests', 'cssID', 'space'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarHeader'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarHeader'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'columnFields' => array
		(
			'module' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_module'],
				'inputType' => 'select',
				'options_callback' => array('Bootstrap\\DataContainer\\Bootstrap', 'getAllModules'),
				'eval' => array('style' => 'width: 300px', 'includeBlankOption' => true, 'chosen' => true),
			),

			'cssClass' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_cssClass'],
				'inputType' => 'text',
				'eval' => array('style' => 'width: 286px', 'rgxp' => 'txt'),
			),
		)
	),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarModules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
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