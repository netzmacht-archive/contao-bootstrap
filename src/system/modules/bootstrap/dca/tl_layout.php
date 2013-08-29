<?php

\MetaPalettes::appendAfter('tl_layout', 'mootools', array(
	'bootstrap' => array('addBootstrap'),
));

$GLOBALS['TL_DCA']['tl_layout']['metasubpalettes']['addBootstrap'] = array(
	'bootstrap_assets',
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['addBootstrap'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['addBootstrap'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'clr', 'submitOnChange' => true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_assets'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_assets'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array(
		'dist/css/bootstrap.min.css' => 'bootstrap.min.css',
		'dist/js/bootstrap.min.js' => 'bootstrap.min.js'
	),
	'eval'                    => array('multiple' => true),
	'sql'                     => "mediumblob NULL"
);