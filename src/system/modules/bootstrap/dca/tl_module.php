<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   netzmacht-bootstrap
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
 */


/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_module']['metapalettes']['bootstrap_navbar'] = array
(
	'title'                     => array('name', 'type'),
	'config'                    => array('bootstrap_navigation', 'bootstrap_isResponsive', 'bootstrap_addHeader', 'bootstrap_navbarModules'),
	'protected'                 => array(':hide', 'protected'),
	'expert'                    => array(':hide', 'guests', 'cssID', 'space'),
	'template'                  => array(':hide', 'bootstrap_navbarTemplate'),
);

$GLOBALS['TL_DCA']['tl_module']['metapalettes']['bootstrap_modal'] = array
(
	'title'                     => array('name', 'headline', 'type'),
	'body'                      => array('bootstrap_modalAjax', 'bootstrap_modalDynamicContent', 'bootstrap_modalContentType'),
	'footer'                    => array('bootstrap_addModalFooter'),
	'protected'                 => array(':hide', 'protected'),
	'expert'                    => array(':hide', 'guests', 'cssID', 'space'),
);

\MetaPalettes::appendFields('tl_module', 'navigation', 'template', array('bootstrap_navClass'));
\MetaPalettes::appendFields('tl_module', 'customnav', 'template', array('bootstrap_navClass'));
\MetaPalettes::appendFields('tl_module', 'quicklink', 'template', array('bootstrap_navClass'));

/**
 * subplaettes
 */
$GLOBALS['TL_DCA']['tl_module']['metasubpalettes']['bootstrap_addHeader'] = array
(
	'bootstrap_navbarBrandTemplate',
);

$GLOBALS['TL_DCA']['tl_module']['metasubselectpalettes']['bootstrap_modalContentType'] = array
(
	'article'   => array('bootstrap_article'),
	'text'      => array('bootstrap_text'),
	'html'      => array('html'),
	'module'    => array('bootstrap_module'),
	'form'      => array('form'),
	'url'       => array('bootstrap_remoteUrl'),
	'template'  => array('bootstrap_modalTemplate'),
);

$GLOBALS['TL_DCA']['tl_module']['metasubpalettes']['bootstrap_addModalFooter'] = array
(
	'bootstrap_addCloseButton',
	'bootstrap_buttons',
);

$GLOBALS['TL_DCA']['tl_module']['metasubpalettes']['bootstrap_addCloseButton'] = array
(
	'bootstrap_closeButton',
);

/**
 * fields
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_isResponsive'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_isResponsive'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => true,
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_addHeader'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_addHeader'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50', 'submitOnChange' => true),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarModules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'tl_class' => '" style="clear:both;',
		'columnFields' => array
		(
			'module' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_module'],
				'inputType' => 'select',
				'options_callback' => array('Netzmacht\Bootstrap\DataContainer\Module', 'getAllModules'),
				'eval' => array('style' => 'width: 300px', 'includeBlankOption' => true, 'chosen' => true),
			),

			'floating' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_floating'],
				'inputType' => 'select',
				'options' => array('left', 'right'),
				'reference' => &$GLOBALS['TL_LANG']['MSC'],
				'eval' => array('style' => 'width: 80px', 'includeBlankOption' => true),
			),

			'cssClass' => array
			(
				'label' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_cssClass'],
				'inputType' => 'text',
				'eval' => array('style' => 'width: 200px', 'rgxp' => 'txt'),
			),
		)
	),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarTemplate'],
	'default'                 => 'mod_navbar',
	'exclude'                 => true,
	'inputType'               => 'singleSelect',
	'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Module', 'getTemplates'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
	'eval'                    => array('templatePrefix' => 'mod_navbar', 'templateThemeId' => 'pid'),
	'sql'                     => "varchar(32) NOT NULL default ''",
);


$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['inputType'] = 'singleSelect';
$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['reference'] = $GLOBALS['TL_LANG']['tl_module'];
$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['options_callback'] = array('Netzmacht\Bootstrap\DataContainer\Module', 'getTemplates');
$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['eval']['templatePrefix'] = 'nav_';
$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['eval']['templateThemeId'] = 'pid';
$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['eval']['tl_class'] = 'w50';

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navClass'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navClass'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "varchar(100) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_addModalFooter'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_addModalFooter'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => true,
	'eval'                    => array('submitOnChange' => true, 'tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_addModalButton'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_addModalButton'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => true,
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_modalContentType'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_modalContentType'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options'                 => array('article', 'text', 'html', 'module', 'form', 'template'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_modalContentType_types'],
	'eval'                    => array('submitOnChange' => true, 'helpwizard' => true, 'tl_class' => 'clr'),
	'sql'                     => "varchar(10) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_buttons'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'default'                 => array
	(
		array
		(
			'type'  => 'button',
			'label' => $GLOBALS['TL_LANG']['MSC']['close'],
			'attributes'   => array(
				array('name' => 'data-dismiss', 'value' => 'modal')
			),
		),
		array('type' => 'button'),
	),

	'eval' => array(
		'tl_class' => 'bootstrapMultiColumnWizard hideSubLabels',
		'decodeEntities' => true,
		'columnFields' => array
		(
			'type' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_type'],
				'exclude'                 => true,
				'inputType'               => 'select',
				'options'                 => array('link', 'group', 'dropdown', 'child', 'header'),
				'reference'               => &$GLOBALS['TL_LANG']['tl_content']['bootstrap_buttons_types'],
				'eval'                    => array('style' => 'width: 90px;', 'valign' => 'top'),
			),

			'label' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_label'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array('style' => 'width: 90px', 'valign' => 'top', 'allowHtml' => true,),
			),

			'url' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_url'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'eval'                    => array('style' => 'width: 90px', 'valign' => 'top', 'rgxp' => 'url', 'decodeEntities'=>true, 'tl_class' => 'wizard'),
				'wizard' => array
				(
					array('Netzmacht\Bootstrap\DataContainer\Module', 'pagePicker')
				),
			),

			'attributes' => array
			(
				'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_attributes'],
				'exclude'                 => true,
				'inputType'               => 'multiColumnWizard',
				'options'                 => array('data-dismiss="modal"', 'class="btn-default"'),
				'eval'                    => array
				(

					'decodeEntities' => true,
					'columnFields' => array
					(
						'name' => array
						(
							//'inputType' => 'customselect',
							'inputType' => 'text',
							'options' => array('class', 'title', 'data-dismiss'),
							'exclude' => true,
							'eval' => array
							(
								'includeBlankOption' => true,
								'style' => 'width: 130px;',
								'placeholder' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_attributes_name'],
							),
						),

						'value' => array
						(
							'inputType' => 'text',
							'exclude' => true,
							'eval' => array('style' => 'width: 80px', 'placeholder' => $GLOBALS['TL_LANG']['tl_module']['bootstrap_buttons_attributes_value']),
						),
					),
				),
			),
		),
	),
	'sql' => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_module'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_module'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Module', 'getAllModules'),
	'eval'                    => array('chosen'=>true),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_article'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_article'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Module', 'getAllArticles'),
	'eval'                    => array('chosen'=>true),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_text'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_text'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'textarea',
	'eval'                    => array('mandatory'=>true, 'rte'=>'tinyMCE', 'helpwizard'=>true),
	'explanation'             => 'insertTags',
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_modalTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_modalTemplate'],
	'exclude'                 => true,
	'inputType'               => 'singleSelect',
	'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Module', 'getTemplates'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
	'eval'                    => array(/*'templatePrefix' => 'bootstrap_modal_',*/ 'templateThemeId' => 'pid', 'chosen' => true),
	'sql'                     => "varchar(64) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarBrandTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarBrandTemplate'],
	'default'                 => 'mod_navbar',
	'exclude'                 => true,
	'inputType'               => 'singleSelect',
	'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
	'options_callback'        => array('Netzmacht\Bootstrap\DataContainer\Module', 'getTemplates'),
	'eval'                    => array('templatePrefix' => 'navbar_brand', 'templateThemeId' => 'pid', 'chosen' => true, 'tl_class' => 'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_modalAjax'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_modalAjax'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => true,
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_modalDynamicContent'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_modalDynamicContent'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'default'                 => true,
	'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''",
);