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

// Wrappers are content elements containing a start, separators and stop elements
// If they are created a generic callback checks how to create or delete the containing elements
// Only change this config if you know what you are doing!
$GLOBALS['BOOTSTRAP']['wrappers'] = array
(
	// Bootstrap tab component
	'tabs' => array
	(
		'start' => array
		(
			'name'          => 'bootstrap_tabStart',
			'triggerCreate' => true, // auto create separators and stop element
			'triggerDelete' => true, // auto deleete separators and stop element
		),

		'separator' => array
		(
			'name'          => 'bootstrap_tabPart',
			'autoCreate'    => true, // can be auto created
			'autoDelete'    => true, // can be auto deleted

			// callback to detect how many separators exists
			'countExisting' => array('Netzmacht\Bootstrap\\DataContainer\\Content', 'countExistingTabSeparators'),

			// callback to detect how many separators are required
			'countRequired' => array('Netzmacht\Bootstrap\\DataContainer\\Content', 'countRequiredTabSeparators'),
		),

		'stop' => array
		(
			'name'       => 'bootstrap_tabEnd',
			'autoCreate' => true,
			'autoDelete' => true,
		),
	),

	// Bootstrap carousel component
	'carousel' => array
	(
		'start' => array
		(
			'name'          => 'bootstrap_carouselStart',
			'autoCreate'    => true,
			'triggerCreate' => true,
			'triggerDelete' => true,
		),

		'separator' => array
		(
			'name'          => 'bootstrap_carouselPart',
			'triggerCreate' => false,
			'autoDelete'    => true,

		),

		'stop' => array
		(
			'name'          => 'bootstrap_carouselEnd',
			'autoCreate'    => true,
			'autoDelete'    => true,
		),
	),

	'accordion' => array
	(
		'start' => array
		(
			'name'          => 'bootstrap_accordionGroupStart',
			'autoCreate'    => true,
			'autoDelete'    => true,
			'triggerCreate' => true,
			'triggerDelete' => true,
		),

		'stop' => array
		(
			'name'          => 'bootstrap_accordionGroupEnd',
			'autoCreate'    => true,
			'autoDelete'    => true,
			'triggerCreate' => true,
			'triggerDelete' => true,
		),
	),
);