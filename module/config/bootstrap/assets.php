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

$GLOBALS['BOOTSTRAP']['assets'] = array
(
	'css' => array
	(
		'bootstrap' => array
		(
			'assets/bootstrap/bootstrap/less/bootstrap.less'             => 'bootstrap.less',
			'assets/bootstrap/bootstrap/dist/css/bootstrap.min.css'      => 'bootstrap.min.css',
			'assets/bootstrap/bootstrap/dist/css/bootstrap-theme.min.css'      => 'bootstrap-theme.min.css',
		),

		'bootstrap-select' => array
		(
			'assets/bootstrap/bootstrap-select/bootstrap-select.min.css' => 'bootstrap-select.min.css',
		),

		'contao-bootstrap' => array
		(
			'system/modules/bootstrap/assets/css/navigation.css' => 'navigation.css',
			'system/modules/bootstrap/assets/css/bootstrap-select-fix.css' => 'bootstrap-select-fix.css',
		)
	),

	'js' => array
	(
		// bootstrap core files
		'bootstrap' => array
		(
			// bootstrap all components
			'assets/bootstrap/bootstrap/dist/js/bootstrap.min.js' => 'bootstrap.min.js',

			// bootstrap components
			'assets/bootstrap/bootstrap/js/transition.js' => 'bootstrap-transition.js',
			'assets/bootstrap/bootstrap/js/affix.js'      => 'bootstrap-affix.js',
			'assets/bootstrap/bootstrap/js/alert.js'      => 'bootstrap-alert.js',
			'assets/bootstrap/bootstrap/js/button.js'     => 'bootstrap-button.js',
			'assets/bootstrap/bootstrap/js/carousel.js'   => 'bootstrap-carousel.js',
			'assets/bootstrap/bootstrap/js/collapse.js'   => 'bootstrap-collapse.js',
			'assets/bootstrap/bootstrap/js/dropdown.js'   => 'bootstrap-dropdown.js',
			'assets/bootstrap/bootstrap/js/popover.js'    => 'bootstrap-dropdown.js',
			'assets/bootstrap/bootstrap/js/modal.js'      => 'bootstrap-modal.js',
			'assets/bootstrap/bootstrap/js/popover.js'    => 'bootstrap-popover.js',
			'assets/bootstrap/bootstrap/js/scrollspy.js'  => 'bootstrap-scrollspy.js',
			'assets/bootstrap/bootstrap/js/tooltip.js'    => 'bootstrap-tooltip.js',
			'assets/bootstrap/bootstrap/js/tab.js'        => 'bootstrap-tab.js',
		),

		'bootstrap-select' => array
		(
			// bootstrap selectpicker
			'assets/bootstrap/bootstrap-select/bootstrap-select.min.js' => 'bootstrap-select.min.js',
		),

		'jquery-touchSwipe' => array
		(
			'assets/bootstrap/jquery-touchSwipe/jquery.touchSwipe.min.js' => 'jquery.touchSwipe.min.js',
		),

		'contao-bootstrap' => array
		(
			'system/modules/bootstrap/assets/js/carousel-swipe.js'   => 'carousel-swipe.js',
			'system/modules/bootstrap/assets/js/modal-reloadable.js' => 'modal-reloadable.js',
			'system/modules/bootstrap/assets/js/navigation.js'       => 'navigation.js',
		)
	),
);