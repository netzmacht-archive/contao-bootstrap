<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 09.08.13
 * Time: 09:03
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;

/**
 * Class ContentButton
 * @package Netzmacht\Bootstrap
 */
class ContentButton extends BootstrapContentElement
{

	/**
	 * bootstrap namespace attributes
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('buttonDisabled', 'buttonSize', 'buttonType', 'icon');

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_button';


	/**
	 * compile button element
	 */
	protected function compile()
	{
		parent::compile();

		if($this->buttonSize == 'default') {
			$this->buttonSize = '';
		}

		if($this->icon) {
			$this->Template->icon = Icons::generateIcon($this->icon);
		}

		parent::compile();
	}
}