<?php

\MetaPalettes::appendTo('tl_settings', array(
	'bootstrap' => array('bootstrapIconSet'),
));

$GLOBALS['TL_DCA']['tl_settings']['bootstrapIconSet'] = array
(
	'label'             => $GLOBALS['TL_LANG']['tl_settings']['bootstrapIconSet'],
	'inputType'         => 'select',
	'options_callback'  => array_keys($GLOBALS['BOOTSTRAP']['icons']['sets']),
	'eval'              => array(),
);