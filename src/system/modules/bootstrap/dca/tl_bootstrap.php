<?php

$this->loadLanguageFile('tl_form_field');

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
				'class'        => 'Netzmacht\Bootstrap\DcGeneral\Data\BootstrapConfigDriver',
				'source' => 'system/config/bootstrap',
				'root'         => 'BOOTSTRAP',
				'ids'          => array('form', 'layout', 'templates'),
				'createDirectory' => true,
			),
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
			'viewport'          => array('viewport'),
			'palettes'   => array(':hide', 'metapalette', 'metasubselectpalettes.rows', 'metasubselectpalettes.cols'),
		),

		'templates' => array
		(
			'templates' => array('dynamicLoad'),
			'modifiers' => array('bar'),
		),

		'form' => array
		(
			'table'          => array('tableFormat', 'defaultTableless'),
			'widgets'        => array(':hide', 'widgets'),
			'styleSelect'    => array(':hide', 'enabled', 'class', 'defaultStyle'),
			'dataAttributes' => array('dataAttributes'),
		),
	),


	'fields' => array
	(
		'viewport' => array
		(
			'inputType' => 'text',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['viewport'],
			'eval'   => array
			(
				'decodeEntities' => true,
				'tl_class' => 'long'
			),
		),

		'metapalette' => array
		(
			'inputType' => 'multiColumnWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['metapalette'],
			'save_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'saveAssociativeFromMcw'),
			),

			'load_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'loadAssociativeForMcw'),
			),

			'eval' => array
			(
				'tl_class' => 'bootstrapMultiColumnWizard hideSubLabels',
				'columnFields' => array
				(
					'legend' => array
					(
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['legend'],
						'inputType' => 'text',
						'eval' => array
						(
							'valign' => 'top',

							'style'     => 'width: 120px; margin-top: 7px; vertical-align: top',
						)
					),

					'fields' => array
					(
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['fields'],
						'inputType' => 'multiColumnWizard',
						'eval' => array
						(
							'flatArray' => true,
							'columnFields' => array
							(
								'fields' => array
								(
									'label' => &$GLOBALS['TL_LANG']['tl_bootstrap']['fields'],
									'inputType' => 'text',
									'eval' => array('style'     => 'width: 400px',),
								),


							),
						),
					),
				),

			),
		),


		'dynamicLoad' => array
		(
			'inputType' => 'multiColumnWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['dynamicLoad'],
			'save_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'saveAssociativeFromMcw'),
			),

			'load_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'loadAssociativeForMcw'),
			),

			'eval' => array
			(
				'tl_class' => 'bootstrapMultiColumnWizard hideSubLabels alignOperations',
				'explanation' => true,


				'columnFields' => array
				(
					'path' => array
					(
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['path'],
						'inputType' => 'text',
						'explanation' => true,
						'eval' => array
						(
							'valign' => 'top',
							'columnPos' => '1',
							'style'     => 'width: 600px; margin-top: 7px; margin-bottom: 7px; vertical-align: top',
						)
					),

					'templates' => array
					(
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['templates'],
						'inputType' => 'multiColumnWizard',
						'eval' => array
						(
							'columnPos' => '1',
							'flatArray' => true,
							'columnFields' => array
							(
								'fields' => array
								(
									'label' => 'test',
									'inputType' => 'text',
									'eval' => array('style'     => 'width: 200px',),
								),


							),
						),
					),
				),

			),
		),

		'widgets' => array
		(
			'inputType' => 'multiColumnWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['widgets'],
			'save_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'saveAssociativeFromMcw'),
			),

			'load_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'loadAssociativeForMcw'),
			),
			'eval'   => array
			(
				'tl_class' => 'bootstrapMultiColumnWizard striped',
				'templatePrefix' => 'form_',
				'buttons' => array('up' => false, 'down' => false),
				'multiColumns' => true,

				'columnFields' => array
				(
					'name' => array
					(
						'inputType' => 'select',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['widget'],
						'options'   => array_keys($GLOBALS['TL_FFL']),
						'reference' => &$GLOBALS['TL_LANG']['FFL'],
						'eval'      => array('style' => 'width: 180px', 'columnPos' => '1'),
					),

					'noFormControl' => array
					(
						'inputType' => 'checkbox',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['noFormControl'],
						'eval'      => array('style' => 'width: 80px; margin-top: 20px;', 'valign' => 'top'),
					),

					'noLabel' => array
					(
						'inputType' => 'checkbox',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['noLabel'],
						'eval'      => array('style' => 'width: 80px; margin-top: 20px;', 'valign' => 'top'),
					),

					'allowInputGroup' => array
					(
						'inputType' => 'checkbox',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['allowInputGroup'],
						'eval'      => array('style' => 'width: 80px; margin-top: 20px;', 'valign' => 'top'),
					),


					'modalFooter' => array
					(
						'inputType' => 'checkbox',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['modalFooter'],
						'eval'      => array('style' => 'width: 80px; margin-top: 20px;', 'valign' => 'top'),
					),

					'styleSelect' => array
					(
						'inputType' => 'checkbox',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['styleSelect'],
						'eval'      => array('style' => 'width: 80px; margin-top: 20px;', 'valign' => 'top'),
					),

					'generateTemplate' => array
					(
						'inputType' => 'select',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['generateTemplate'],
						'options_callback' => array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'getTemplates'),
						'eval'      => array('style' => 'width: 180px', 'columnPos' => '1', 'includeBlankOption' => true),
					),
				),
			),
		),

		'defaultTableless' => array
		(
			'inputType' => 'checkbox',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['defaultTableless'],
			'eval'   => array
			(
				'tl_class' => 'w50'
			),
		),

		'tableFormat' => array
		(
			'inputType' => 'multiColumnWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['tableFormat'],
			'save_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'saveAssociativeFromMcw'),
			),

			'load_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'loadAssociativeForMcw'),
			),
			'eval'   => array
			(
				'tl_class' => 'bootstrapMultiColumnWizard',

				'columnFields' => array
				(
					'type' => array
					(
						'inputType' => 'text',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['tableFormat_type'],
						'eval'      => array('style' => 'width: 150px', 'readonly' => true),
					),

					'value' => array
					(
						'inputType' => 'text',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['tableFormat_class'],
						'eval'      => array('style' => 'width: 350px'),
					),
				),

				'buttons' => array('up' => false, 'copy' => 'false', 'down' => false, 'delete' => false),
			),
		),

		'enabled' => array
		(
			'inputType' => 'checkbox',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['styleSelect_enabled'],
			'subPath' => array('styleSelect'),
			'load_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'loadSubPath'),
			),
			'save_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'saveToSubSection'),
			),
			'eval'   => array
			(

				'tl_class' => ''
			),
		),

		'class' => array
		(
			'inputType' => 'text',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['styleSelect_enabled'],
			'subPath' => array('styleSelect'),
			'load_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'loadSubPath'),
			),
			'save_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'saveToSubSection'),
			),
			'eval'   => array
			(

				'tl_class' => 'w50'
			),
		),

		'defaultStyle' => array
		(
			'inputType' => 'text',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['styleSelect_enabled'],
			'subPath' => array('styleSelect'),
			'load_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'loadSubPath'),
			),
			'save_callback' => array
			(
				array('Netzmacht\Bootstrap\DataContainer\Bootstrap', 'saveToSubSection'),
			),
			'eval'   => array
			(

				'tl_class' => 'w50'
			),
		),


		'dataAttributes' => array
		(
			'inputType' => 'listWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['dataAttributes'],
			'eval'   => array
			(
				'multiple' => true,
				'size'  => 1,
			),
		),

	),

);