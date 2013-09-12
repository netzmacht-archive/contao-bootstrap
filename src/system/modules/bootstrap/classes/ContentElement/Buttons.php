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

namespace Netzmacht\Bootstrap\ContentElement;

use Netzmacht\Bootstrap\Helper;
/**
 * Class ContentToolbar
 * @package Netzmacht\Bootstrap
 */
class Buttons extends BootstrapAbstract
{

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('buttons', 'buttonStyle');

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_buttons';


	/**
	 * compile the button toolbar
	 */
	protected function compile()
	{
		$buttons = new Helper\Buttons();
		$buttons->loadFromFieldset($this->buttons);
		$buttons->buttonStyle = $this->buttonStyle;

		$this->Template->buttons = $buttons;
	}

}