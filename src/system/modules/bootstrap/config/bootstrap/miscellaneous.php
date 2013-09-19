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


$GLOBALS['BOOTSTRAP']['icons'] = array
(
	// registered icons sets
	'sets' => array
	(
		'glyphicons'    => array
		(
			'path'      => 'system/modules/bootstrap/config/bootstrap/glyphicons.php',
			'template'  => '<span class="glyphicon glyphicon-%s"></span>',
		),
	),

	// the array where all icons are defined
	'set' => array(),

	// which tag shall be used for icons
	'template' => array(),
);

$GLOBALS['BOOTSTRAP']['dropdown'] = array
(
	// element which is used as download toggler
	'toggle' => '<b class="caret"></b>',

	'formless' => array
	(
		'mod_quicklink',
		/* 'mod_quicknav' */
	),
);

$GLOBALS['BOOTSTRAP']['modal'] = array
(
		'dismiss' => '&times;',

		'adjustForm' => true,

		'remoteUrl'        => 'SimpleAjax.php?page=%s&amp;modal=%s',
		'remoteDynamicUrl' => 'SimpleAjax.php?page=%s&amp;modal=%s&amp;dynamic=%s&amp;id=%s',
);