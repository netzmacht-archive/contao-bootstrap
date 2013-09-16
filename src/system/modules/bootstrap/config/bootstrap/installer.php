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

$GLOBALS['BOOSTRAP']['installer'] = array
(
	'hooky' => array
	(
		'file'      => 'https://github.com/xat/contao-hooky/archive/master.zip',
		'root'      => 'contao-hooky-master/src/',
		'target'    => '',
		'condition' => function() {
			return !class_exists('Hooky');
		},
	),

	'bootstrap' => array
	(
		'file'        => 'https://github.com/twbs/bootstrap/archive/v3.0.0.zip',
		'root'        => 'bootstrap-3.0.0/',
		'target'      => 'assets/bootstrap/bootstrap/',
		'clearTarget' => true,
		'paths'       => array
		(
			'js',
			'less',
			'fonts',
			'dist',
			'LICENSE',
			'assets/js/html5shiv.js',
			'assets/js/respond.min.js',

		),
	),

	'bootstrap-select' => array
	(
		'file'        => 'https://github.com/silviomoreto/bootstrap-select/archive/1.3.1.zip',
		'root'        => 'bootstrap-select-1.3.1',
		'target'      => 'assets/bootstrap/bootstrap-select/',
		'clearTarget' => true,
	),

	'jquery-touchSwipe' => array
	(
		'file'        => 'https://github.com/mattbryson/TouchSwipe-Jquery-Plugin/archive/1.6.4.zip',
		'root'        => 'TouchSwipe-Jquery-Plugin-1.6.4/',
		'target'      => 'assets/bootstrap/jquery-touchSwipe/',
		'clearTarget' => true,
		'paths'       => array
		(
			'jquery.touchSwipe.min.js',
			'README.md'
		),
	)
);