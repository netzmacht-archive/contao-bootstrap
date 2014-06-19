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

$GLOBALS['BOOTSTRAP']['form'] = array
(
	'widgets' => array
	(
		'button' => array
		(
			'noFormControl'    => true,
			'modalFooter'      => true,
		),

		'captcha' => array
		(
			'allowInputGroup'  => true,
		),

		'checkbox' => array
		(
			'noFormControl'    => true,
			'noLabel'          => true,
			'generateTemplate' => 'form_checkbox_generate',
		),

		'explanation' => array(
			'noFormControl'    => true,
		),

		'headline' => array(
			'noFormControl'    => true,
		),

		'radio' => array
		(
			'noFormControl'    => true,
			'noLabel'          => true,
			'generateTemplate' => 'form_radio_generate',
		),

		'submit' => array
		(
			'noFormControl'    => true,
			'noLabel'          => true,
			'modalFooter'      => true,
		),

		'select' => array
		(
			'styleSelect'      => true,
		),

		'text' => array
		(
			'allowInputGroup'  => true,
		),

		'email' => array
		(
			'allowInputGroup'  => true,
		),


		'digit' => array
		(
			'allowInputGroup'  => true,
		),

		'tel' => array
		(
			'allowInputGroup'  => true,
		),

		'url' => array
		(
			'allowInputGroup'  => true,
		),

		'textarea' => array
		(
			'allowInputGroup'  => true,
		),

		'password' => array
		(
			'allowInputGroup'  => true,
		),

	),

	// which columns shall be used for the form in table mode
	'tableFormat' => array
	(
		'label'         => 'col-lg-3',
		'control'       => 'col-lg-9',
		'offset'        => 'col-lg-offset-3',
	),

	// how to display forms like comments form by default
	'defaultTableless'  => true,

	// add style select to select list, set to false to disable
	'styleSelect' => array
	(
		'enabled'       => true,
		'class'         => 'selectpicker',
		'defaultStyle'  => 'btn-default',
	),

	// style the upload button
	'styledUpload' => array
	(
		'enabled'	    => true,
		'class'			=> 'btn btn-primary',
		'position'	    => 'right',
		'onchange'	    => 'document.getElementById(\'%s_value\').value=this.value.replace(/C:\\\\fakepath\\\\/i, "");return false;',
		'label'			=> &$GLOBALS['TL_LANG']['MSC']['bootstrapUploadButton']
	),

	// provides data attributes for custom select
	'dataAttributes' => array('target', 'toggle', 'dismiss', 'remote'),
);