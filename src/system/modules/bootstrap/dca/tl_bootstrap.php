<?php

$GLOBALS['TL_DCA']['tl_bootstrap'] = array
(
	'config' => array
	(
		'dataContainer' => 'General',
		'enableVersioning' => false,
		'closed' => true,
	),

	'dca_config' => array
	(
		'data_provider' => array
		(
			'default' => array
			(
				'class' => 'Netzmacht\Bootstrap\DcGeneral\Data\BootstrapConfigDriver',
				'source' => 'system/config/bootstrap',
				'createSource' => true,
			),
			'folder'  => 'system/modules/bootstrap/config/bootstrap',

		),
	),

	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('viewport'),
		),

		'label' => array
		(
			'fields' => array('id', 'viewport'),
		),

		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_content']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
		),
	),

	'palettes' => array
	(
		'__selector__' => array('id'),
	),

	'metapalettes' => array
	(
		'default' => array
		(
			'test' => array('id'),
		),

		'layout' => array
		(
			'test' => array('viewport'),
		),
	),


	'fields' => array
	(
		'viewport' => array
		(
			'inputType' => 'text',
		),

	),

);