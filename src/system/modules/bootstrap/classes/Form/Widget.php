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

namespace Netzmacht\Bootstrap\Form;

use Netzmacht\Bootstrap\Helper\Icons;


/**
 * Class BootstrapWidget works as delegator for the default widget for adding bootstrap specific handling
 * attributes
 *
 * @package Netzmacht\Bootstrap
 */
class Widget
{

	/**
	 * @var \Widget
	 */
	protected $widget;

	/**
	 * @var string
	 */
	protected $strFormat = 'html5';

	/**
	 * @var string
	 */
	protected $strTagEnding = '>';


	/**
	 * @param \Widget $widget
	 */
	public function __construct(\Widget $widget)
	{
		$this->widget = $widget;

		if(!$this->getConfiguration('noFormControl')) {
			$this->class = 'form-control';
		}

		if(!$this->tableless) {
			$this->columnClass = $GLOBALS['BOOTSTRAP']['form']['tableFormat']['control'];

			if(!$this->label || $this->getConfiguration('noLabel'))
			{
				$this->columnClass .= ' ' . $GLOBALS['BOOTSTRAP']['form']['tableFormat']['offset'];
			}
		}

		$this->inline = (bool) $this->bootstrap_inlineStyle;

		// avoid submit button if input group can be created
		if($this->addSubmit && $this->getConfiguration('allowInputGroup'))
		{
			$this->addSubmit = false;
			$this->addInputGroupSubmit = true;
		}
	}


	/**
	 * @param $name
	 * @param $value
	 */
	public function __set($name, $value)
	{
		$this->widget->$name = $value;
	}


	/**
	 * @param $name
	 * @return string
	 */
	public function __get($name)
	{
		return $this->widget->$name;
	}


	/**
	 * @param $method
	 * @param $arguments
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->widget, $method), $arguments);
	}


	/**
	 * @param $method
	 * @param $arguments
	 * @return mixed
	 */
	public static function __callStatic($method, $arguments)
	{
		return call_user_func_array(array('\\Widget', $method), $arguments);
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function __isset($name)
	{
		return isset($this->widget->$name);
	}


	/**
	 * @param $name
	 */
	public function __unset($name)
	{
		unset($this->widget->$name);
	}


	/**
	 * Generate the label and return it as string
	 *
	 * @return string The label markup
	 */
	public function generateLabel()
	{
		if ($this->label == '')
		{
			return '';
		}

		return sprintf('<label%s class="control-label %s">%s%s%s</label>',
			($this->forAttribute ? ' for="ctrl_' . $this->id . '"' : ''),
			((!$this->tableless) ? $GLOBALS['BOOTSTRAP']['form']['tableFormat']['label'] : ''),
			($this->required ? '<span class="invisible">'.$GLOBALS['TL_LANG']['MSC']['mandatory'].'</span> ' : ''),
			$this->label,
			($this->required ? '<span class="mandatory">*</span>' : ''));
	}



	/**
	 * Generates the widget. Allow different widgets types using a defined template for rendering.
	 * By this way it is possible to adjust different generate methods without redeclare every class
	 *
	 * If no template is set by configuration, the default generate method is used
	 *
	 * @return string
	 */
	public function generate()
	{
		$isModal = isset($GLOBALS['bootstrapModalForm']) &&
			$GLOBALS['BOOTSTRAP']['modal']['adjustForm'] &&
			$this->getConfiguration('modalFooter');

		// modal form support
		if($isModal)
		{
			$widgetId = $this->widget->id;
			$this->widget->onclick = sprintf('$(\'#ctrl_%s\').click();', $this->widget->id);
			$this->widget->id = 'md_' . $widgetId;
		}

		// generating using defined templates
		if($this->getConfiguration('generateTemplate'))
		{
			ob_start();
			include $this->getTemplate($this->getConfiguration('generateTemplate'), $this->strFormat);
			$widget = ob_get_contents();
			ob_end_clean();
		}
		else
		{
			// styleSelect support
			if($GLOBALS['BOOTSTRAP']['form']['styleSelect']['enabled'] && $this->getConfiguration('styleSelect'))
			{
				$this->class = $GLOBALS['BOOTSTRAP']['form']['styleSelect']['class'];
				$this->addAttribute('data-style', $GLOBALS['BOOTSTRAP']['form']['styleSelect']['style']);
			}

			$widget = $this->widget->generate();
		}

		// create input groups
		if($this->getConfiguration('allowInputGroup'))
		{
			return $this->generateInputGroup($widget);
		}

		// modal form support, render widget again invisible
		if($isModal)
		{
			$GLOBALS['bootstrapModalForm'] .= $widget;

			$this->widget->class = 'invisible';
			$this->widget->onclick = '';
			$this->widget->id = $widgetId;

			$widget =  $this->widget->generate();
		}

		return $widget;
	}


	/**
	 * Generate the widget with error message and return it as string. We have to redeclare this method so that
	 * the modified generate method is used
	 *
	 * @param boolean $blnSwitchOrder If true, the error message will be shown below the field
	 *
	 * @return string The form field markup
	 */
	public function generateWithError($blnSwitchOrder=false)
	{
		$strWidget = $this->generate();
		$strError = $this->getErrorAsHTML();

		return $blnSwitchOrder ? $strWidget . $strError : $strError . $strWidget;
	}


	/**
	 * @param $strName
	 * @return bool
	 */
	public function getConfiguration($strName)
	{
		if(isset($GLOBALS['BOOTSTRAP']['form']['widgets'][$this->type][$strName]))
		{
			return $GLOBALS['BOOTSTRAP']['form']['widgets'][$this->type][$strName];
		}

		return false;
	}


	/**
	 * Return a particular error as HTML string
	 *
	 * @param integer $intIndex The message index
	 *
	 * @return string The HTML markup of the corresponding error message
	 */
	public function getErrorAsHTML($intIndex=0)
	{
		return $this->hasErrors() ? sprintf('<span class="%s">%s</span>', ((TL_MODE == 'BE') ? 'tl_error tl_tip' : 'help-block'), $this->getErrorAsString($intIndex)) : '';
	}


	/**
	 * parse widget and set form group class
	 * @param null $arrAttributes
	 * @return string
	 */
	public function parse($arrAttributes=null)
	{
		if ($this->template == '')
		{
			return '';
		}

		$this->addAttributes($arrAttributes);
		$this->container = 'form-group';

		if($this->hasErrors()) {
			$this->container .= ' has-error';
		}

		$this->addAttributes($arrAttributes);

		ob_start();
		include $this->getTemplate($this->template, $this->strFormat);
		$strBuffer = ob_get_contents();
		ob_end_clean();

		return $strBuffer;
	}


	/**
	 * Generate a submit button
	 *
	 * @return string The submit button markup
	 */
	protected function addSubmit($force=false)
	{
		if (!$force && (!$this->addSubmit || $this->getConfiguration('allowInputGroup')))
		{
			return '';
		}

		$label = specialchars($this->slabel);

		if($this->bootstrap_addSubmitIcon) {
			$icon = Icons::generateIcon($this->bootstrap_addSubmitIcon);

			if($this->bootstrap_addSubmitIconPosition == 'right') {
				$label .= ' ' . $icon;
			}
			else {
				$label = $icon . ' ' . $label;
			}
		}

		return sprintf(' <button type="submit" id="ctrl_%s_submit" class="btn %s">%s</button>',
			$this->strId,
			$this->bootstrap_addSubmitClass ? : 'btn-default',
			$label
		);
	}


	/**
	 * Check whether an option is checked
	 *
	 * @param array $arrOption The options array
	 *
	 * @return string The "checked" attribute or an empty string
	 */
	protected function isChecked($arrOption)
	{
		if (empty($this->value) && $arrOption['default'])
		{
			return $this->optionChecked(1, 1);
		}

		return $this->optionChecked($arrOption['value'], $this->value);
	}


	/**
	 * generate the input group
	 *
	 * @param $widget
	 *
	 * @return string
	 */
	protected function generateInputGroup($widget)
	{
		$addOn = '<span class="input-group-addon">%s</span>';
		$left = '';
		$right = '';

		// icon is added
		if($this->bootstrap_addIcon) {
			$icon = Icons::generateIcon($this->bootstrap_icon);

			if($this->bootstrap_iconPosition == 'right') {
				$right .= sprintf($addOn, $icon);
			}
			else {
				$left .= sprintf($addOn, $icon);

			}
		}

		// unit is addes
		if($this->bootstrap_addUnit) {
			if($this->bootstrap_unitPosition == 'right') {
				$right .= sprintf($addOn, $this->bootstrap_unit);
			}
			else {
				$left .= sprintf($addOn, $this->bootstrap_unit);
			}
		}

		if($this->addInputGroupSubmit) {
			$submit = $this->addSubmit(true);

			$right .= sprintf('<span class="input-group-btn">%s</span>', $submit);
		}

		if($this->type == 'captcha')
		{
			$right .= $this->generateQuestion(true);
		}

		if($left != '' || $right != '') {
			return '<div class="input-group">' . $left . $widget . $right . '</div>';
		}

		return $widget;
	}


	/**
	 * generate the question for the captcha as input group
	 *
	 * @return mixed
	 * @throws \BadMethodCallException
	 */
	public function generateQuestion($force=false)
	{
		if($this->type != 'captcha') {
			throw new \BadMethodCallException('BootstrapWidget::generateQuestion can only be called by Captcha');
		}

		if(!$force && $this->getConfiguration('allowInputGroup'))
		{
			return '';
		}

		$class = $this->getConfiguration('allowInputGroup') ? 'input-group-addon' : 'help-block';

		$question = $this->widget->generateQuestion();
		return preg_replace('/(class=\")([^\"]*)\"/', 'class="question ' . $class . '"', $question);
	}


	/**
	 * @return string
	 * @throws \BadMethodCallException
	 */
	public function generateConfirmationLabel()
	{
		if($this->type != 'password') {
			throw new \BadMethodCallException('BootstrapWidget::generateConfirmationLabel can only be called by password widget');
		}

		return sprintf('<label for="ctrl_%s_confirm" class="confirm%s">%s%s%s</label>',
			$this->strId,
			' control-label' . ($this->tableless ? '' : ' ' . $GLOBALS['BOOTSTRAP']['form']['tableFormat']['label']),
			($this->required ? '<span class="invisible">'.$GLOBALS['TL_LANG']['MSC']['mandatory'].'</span> ' : ''),
			sprintf($GLOBALS['TL_LANG']['MSC']['confirmation'], $this->strLabel),
			($this->required ? '<span class="mandatory">*</span>' : ''));
	}

}