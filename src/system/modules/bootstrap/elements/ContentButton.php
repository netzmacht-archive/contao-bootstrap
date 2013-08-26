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
class ContentButton extends \ContentHyperlink
{

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_button';


	/**bootstrap_buttonSize
	 *
	 */
	protected function compile()
	{
		if($this->bootstrap_buttonSize == 'default') {
			$this->bootstrap_buttonSize = '';
		}

		if($this->bootstrap_icon) {
			$this->Template->icon = Icons::generateIcon($this->bootstrap_icon);
		}

		parent::compile();
	}
}