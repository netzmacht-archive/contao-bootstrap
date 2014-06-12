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

namespace Netzmacht\Bootstrap\Template\Modifier;

use Netzmacht\Bootstrap\Bootstrap;


/**
 * Class Layout contails modifier for setting up page layout
 * @package Netzmacht\Bootstrap\Template\Modifier
 */
class Layout
{

	/**
	 * @var string
	 */
	protected static $classAttribute = ' class="%s"';


	/**
	 * @param \Template $template
	 */
	public static function initialize(\Template $template)
	{
		static::initializeViewport($template);
		static::initializeColumns($template);
		static::initializeRows($template);
	}


	/**
	 * initialize layout columns
	 *
	 * set up if needed mainClass, leftClass, rightClass which contains class names
	 * set up if needed mainClassAttribute, leftClassAttribute, rightClassAttribute containing ' class="classname"'
	 *
	 * @param \Template $template
	 */
	protected static function initializeColumns(\Template $template)
	{
		$layout = Bootstrap::getLayout();

		switch($layout->cols)
		{
			case '2cll':
				$template->leftClass           = $layout->bootstrap_leftClass;
				$template->mainClass           = $layout->bootstrap_mainClass;

				$template->mainClassAttribute  = sprintf(static::$classAttribute, $layout->bootstrap_mainClass);
				$template->leftClassAttribute  = sprintf(static::$classAttribute, $layout->bootstrap_leftClass);
				break;

			case '2clr':
				$template->rightClass          = $layout->bootstrap_rightClass;
				$template->mainClass           = $layout->bootstrap_mainClass;

				$template->mainClassAttribute  = sprintf(static::$classAttribute, $layout->bootstrap_mainClass);
				$template->rightClassAttribute = sprintf(static::$classAttribute, $layout->bootstrap_rightClass);
				break;

			case '3cl':
				$template->leftClass           = $layout->bootstrap_leftClass;
				$template->rightClass          = $layout->bootstrap_rightClass;
				$template->mainClass           = $layout->bootstrap_mainClass;

				$template->mainClassAttribute  = sprintf(static::$classAttribute, $layout->bootstrap_mainClass);
				$template->rightClassAttribute = sprintf(static::$classAttribute, $layout->bootstrap_rightClass);
				$template->leftClassAttribute  = sprintf(static::$classAttribute, $layout->bootstrap_leftClass);
				break;

			default:
				$template->useGrid = false;
				return;
		}

		$template->useGrid = true;
	}


	/**
	 * initialize layout rows
	 *
	 * creates headerClass, footerClass, headerClassAttribute, footerClassAttribute
	 *
	 * @param \Template $template
	 */
	protected static function initializeRows($template)
	{
		$layout = Bootstrap::getLayout();

		switch($layout->rows)
		{
			case '2rwh':
				$template->headerClass           = $layout->bootstrap_headerClass;

				$template->headerClassAttribute = sprintf(static::$classAttribute, $layout->bootstrap_headerClass);
				break;

			case '2rwf':
				$template->footerClass           = $layout->bootstrap_footerClass;

				$template->footerClassAttribute = sprintf(static::$classAttribute, $layout->bootstrap_footerClass);
				break;

			case '3rw':
				$template->headerClass           = $layout->bootstrap_headerClass;
				$template->footerClass           = $layout->bootstrap_footerClass;

				$template->headerClassAttribute = sprintf(static::$classAttribute, $layout->bootstrap_headerClass);
				$template->footerClassAttribute = sprintf(static::$classAttribute, $layout->bootstrap_footerClass);
				break;
		}
	}


	/**
	 * @param $template
	 */
	protected static function initializeViewport($template)
	{
		$layout = \Netzmacht\Bootstrap\Bootstrap::getLayout();

		if($layout->viewport)
		{
			$template->viewport = sprintf('<meta name="viewport" content="%s">', $layout->viewport);
		}
	}



	/**
	 * @param \Template $template
	 */
	public static function replaceClasses($buffer)
	{
		if (empty($GLOBALS['BOOTSTRAP']['classes'])) {
			return $buffer;
		}

		$classes = array_keys($GLOBALS['BOOTSTRAP']['classes']);
		$classes = array_map(function($class) { return preg_quote($class, '~'); }, $classes);

		$search = sprintf('~class="([^"]*(%s)[^"]*)"~', implode('|', $classes));

		$buffer = preg_replace_callback(
			$search,
			function ($matches) {
				$classes = explode(' ', $matches[1]);
				$classes = array_filter($classes);

				foreach ($classes as $index => $class) {
					if (isset($GLOBALS['BOOTSTRAP']['classes'][$class])) {
						$classes[$index] = $GLOBALS['BOOTSTRAP']['classes'][$class];
					}
				}

				return sprintf('class="%s"', implode(' ', $classes));
			},
			$buffer
		);

		return $buffer;
	}
}