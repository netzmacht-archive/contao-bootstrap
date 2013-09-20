<?php

array_insert($GLOBALS['TL_DCA']['tl_theme']['list']['global_operations'], 2, array
(
	'bootstrap' => array
	(
		'label'               => $GLOBALS['TL_LANG']['MSC']['bootstrap'],
		'href'                => 'table=tl_bootstrap',
		'class'               => 'header_bootstrap',
		'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="b"',
	),
));