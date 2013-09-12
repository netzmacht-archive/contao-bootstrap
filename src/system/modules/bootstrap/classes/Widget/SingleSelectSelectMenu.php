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


namespace Netzmacht\Bootstrap\Widget;


/**
 * Class SingleSelectSelectMenu only allow first value in select menu be checked, no matter how many options
 * are available
 * @package Netzmacht\Bootstrap\Widget
 */
class SingleSelectSelectMenu extends \SelectMenu
{

	/**
	 * @var bool
	 */
	protected $isSelectedSet = false;


	/**
	 * @param array $option
	 *
	 * @return string
	 */
	protected function isSelected($option)
	{
		if(!$this->multiple && $this->isSelectedSet)
		{
			return '';
		}

		$check = parent::isSelected($option);

		$this->isSelectedSet = ($check != '');

		return $check;
	}

}