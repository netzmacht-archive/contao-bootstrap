<?php

use Netzmacht\DcGeneral\Data\ConfigFileDriver;

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
				'class'        => 'Netzmacht\DcGeneral\Data\ConfigFileDriver',
				'source'       => 'tl_bootstrap',
				'path'         => 'system/config/bootstrap.php',
				'root'         => 'BOOTSTRAP',
				'ids'          => array('miscellaneous', 'form', 'layout', 'templates'),
				'autoCreate'   => true,
			),
		),
	),

	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('id'),
		),

		'label' => array
		(
			'fields' => array('id'),
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

		'global_operations' => array
		(
			'back' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT'],
				'href'                => 'do=themes&amp;table=tl_theme&amp;rt=' . REQUEST_TOKEN,
				'class'               => 'header_back',
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
			'palettes'   => array
			(
				':hide',
				ConfigFileDriver::pathToField('layout', 'metapalette'),
			),
			'gridClasses' => array
			(
				':hide',
				ConfigFileDriver::pathToField('layout', 'metasubselectpalettes', 'rows'),
				ConfigFileDriver::pathToField('layout', 'metasubselectpalettes', 'cols'),
			),
		),

		'templates' => array
		(
			'templates' => array
			(
				ConfigFileDriver::pathToField('templates', 'dynamicLoad', 'system/modules/bootstrap/templates/theme')
			),
			'modifiers' => array
			(
				ConfigFileDriver::pathToField('templates', 'bar'),
			),
		),

		'form' => array
		(
			'table'          => array
			(
				ConfigFileDriver::pathToField('form', 'tableFormat'),
				ConfigFileDriver::pathToField('form', 'defaultTableless'),
			),
			'widgets'        => array(':hide', 'widgets'),
			'styleSelect'    => array
			(
				':hide',
				ConfigFileDriver::pathToField('form', 'styleSelect', 'enabled'),
				ConfigFileDriver::pathToField('form', 'styleSelect', 'class'),
				ConfigFileDriver::pathToField('form', 'styleSelect', 'defaultStyle'),
			),
			'dataAttributes' => array
			(
				ConfigFileDriver::pathToField('form', 'dataAttributes')
			),
		),

		'miscellaneous' => array
		(
			'icons' => array
			(
				ConfigFileDriver::pathToField('miscellaneous', 'icons', 'active'),
				ConfigFileDriver::pathToField('miscellaneous', 'icons', 'sets')
			),

		)
	),


	'fields' => array
	(
		'id' => array
		(
			'reference' => &$GLOBALS['TL_LANG']['tl_bootstrap'],
		),

		ConfigFileDriver::pathToField('layout', 'metapalette') => array
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
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['fields_extend'],
						'inputType' => 'multiColumnWizard',
						'eval' => array
						(
							'flatArray' => true,
							'columnFields' => array
							(
								'fields' => array
								(
									'label' => &$GLOBALS['TL_LANG']['tl_bootstrap']['fields_extend'],
									'inputType' => 'text',
									'eval' => array('style'     => 'width: 400px',),
								),


							),
						),
					),
				),

			),
		),


		ConfigFileDriver::pathToField('layout', 'metasubselectpalettes', 'rows') => array
		(
			'inputType' => 'multiColumnWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['metasubselectpalettes_rows'],
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
				'tl_class'     => 'bootstrapMultiColumnWizard hideSubLabels',
				'buttons'      => array('up' => false, 'down' => false, 'copy' => false, 'delete' => false),
				'columnFields' => array
				(
					'legend' => array
					(
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['subselectpalette'],
						'inputType' => 'text',
						'eval' => array
						(
							'valign'    => 'top',
							'readonly'  => true,
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

		ConfigFileDriver::pathToField('layout', 'metasubselectpalettes', 'cols') => array
		(
			'inputType' => 'multiColumnWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['metasubselectpalettes_cols'],
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
				'tl_class'     => 'bootstrapMultiColumnWizard hideSubLabels',
				'buttons'      => array('up' => false, 'down' => false, 'copy' => false, 'delete' => false),
				'columnFields' => array
				(
					'legend' => array
					(
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['subselectpalette'],
						'inputType' => 'text',
						'eval' => array
						(
							'valign' => 'top',
							'readonly'  => true,
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


		ConfigFileDriver::pathToField('templates', 'dynamicLoad', 'system/modules/bootstrap/templates/theme') => array
		(
			'inputType' => 'listWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['dynamicLoad'],

			'eval' => array
			(
				'multiple' => true,
				'size' => 1,
			),
		),

		ConfigFileDriver::pathToField('form', 'widgets') => array
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

		ConfigFileDriver::pathToField('form', 'defaultTableless') => array
		(
			'inputType' => 'checkbox',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['defaultTableless'],
			'eval'   => array
			(
				'tl_class' => 'w50'
			),
		),

		ConfigFileDriver::pathToField('form', 'tableFormat') => array
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

		ConfigFileDriver::pathToField('form', 'styleSelect', 'enabled') => array
		(
			'inputType' => 'checkbox',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['styleSelect_enabled'],
			'eval'   => array
			(

				'tl_class' => ''
			),
		),

		ConfigFileDriver::pathToField('form', 'styleSelect', 'class') => array
		(
			'inputType' => 'text',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['styleSelect_enabled'],
			'eval'   => array
			(

				'tl_class' => 'w50'
			),
		),

		ConfigFileDriver::pathToField('form', 'styleSelect', 'defaultStyle') => array
		(
			'inputType' => 'text',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['styleSelect_enabled'],
			'eval'   => array
			(

				'tl_class' => 'w50'
			),
		),

		ConfigFileDriver::pathToField('form', 'dataAttributes') => array
		(
			'inputType' => 'listWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['dataAttributes'],
			'eval'   => array
			(
				'multiple' => true,
				'size'  => 1,
			),
		),

		ConfigFileDriver::pathToField('miscellaneous', 'icons', 'active') => array
		(
			'inputType' => 'select',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['icons'],
			'options'   => array_keys($GLOBALS['BOOTSTRAP']['icons']['sets']),
			'eval'   => array
			(
			),
		),

		ConfigFileDriver::pathToField('miscellaneous', 'icons', 'sets') => array
		(
			'inputType' => 'multiColumnWizard',
			'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['icons'],
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
				'tl_class'     => 'bootstrapMultiColumnWizard alignOperations',
				'multiColumns' => true,
				'columnFields' => array
				(
					'name' => array
					(
						'inputType' => 'text',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['icons_name'],
						'eval'   => array
						(
							'valign' => 'top',
							'columnPos' => '1',
							'style' => 'width: 150px',
						),
					),

					'path' => array
					(
						'inputType' => 'text',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['icons_path'],
						'eval'   => array
						(
							'columnPos' => '2',
							'style' => 'width: 350px',
						),
					),

					'template' => array
					(
						'inputType' => 'text',
						'label'     => &$GLOBALS['TL_LANG']['tl_bootstrap']['icons_template'],
						'eval'   => array
						(
							'columnPos' => '2',
							'style' => 'width: 350px',
							'allowHtml' => true,
							'preserveTags' => true,
						),
					),


				),
			),
		),

	),

);