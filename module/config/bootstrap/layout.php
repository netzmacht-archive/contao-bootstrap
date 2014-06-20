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

$GLOBALS['BOOTSTRAP']['layout'] = array
(
	// customize default palette. we remove the stuff we do not want to
	// Using this way it is possible for other extensions to plug in the default palette
	// MetaPalettes extending feature can be used
	'metapalette'  => array
	(
		'+title'    => array('layoutType'),
		'-sections' => array('sPosition'),
		'-style'    => array('framework', 'stylesheet', 'external', '+bootstrap_importStylesheets'),
		'+script'   => array('bootstrap_importJavaScripts after theme_plus_javascripts'),
		'-static'   => array('static'),
	),

	// modification of the default subpalettes by using metasubselectpalettes
	'metasubselectpalettes' => array
	(
		'rows' => array
		(
			'2rwh'  => array('bootstrap_headerClass'),
			'2rwf'  => array('bootstrap_footerClass'),
			'3rw'   => array('bootstrap_headerClass', 'bootstrap_footerClass'),
		),

		'cols' => array
		(
			'1cl'    => array(),
			'2cll'   => array('bootstrap_leftClass', 'bootstrap_mainClass'),
			'2clr'   => array('bootstrap_mainClass', 'bootstrap_rightClass'),
			'3cl'    => array('bootstrap_leftClass', 'bootstrap_mainClass', 'bootstrap_rightClass'),
		),
	),
);

if(version_compare(VERSION, '3.3', '<')) {
	$GLOBALS['BOOTSTRAP']['layout']['metapalette']['+expert'][] = 'viewport after cssClass';
}