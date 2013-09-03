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

namespace Netzmacht\Bootstrap;


/**
 * Class BootstrapWrapperElement provides methods for generating wrapping elements like slider or tab
 *
 * @package Netzmacht\Bootstrap
 */
abstract class BootstrapWrapperElement extends BootstrapContentElement
{

	/**
	 * store start element
	 * @var array
	 */
	protected static $arrStartElement;

	/**
	 * @var ContentWrapperModel
	 */
	protected $objModel;

	/**
	 * @var string
	 */
	protected static $strWrapperName = 'tabs';


	/**
	 * load start element
	 *
	 * @param $objElement
	 */
	public function __construct($objElement)
	{
		if($objElement instanceof \Model\Collection && !$objElement instanceof ContentWrapperCollection)
		{
			$objElement = $objElement->current();
		}

		if(!$objElement instanceof ContentWrapperModel)
		{
			$row = $objElement->row();

			$objElement = new ContentWrapperModel();
			$objElement->setRow($row);
		}

		parent::__construct($objElement);
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		// backend mode
		if(TL_MODE == 'BE')
		{
			if($this->objModel->getType() == ContentWrapperModel::TYPE_STOP)
			{
				return '';
			}

			return $this->generateTitle();
		}

		$this->wrapperType = $this->objModel->getType();

		return parent::generate();
	}


	/**
	 * generate the title of a part
	 * @return string
	 */
	protected function generateTitle()
	{
		if(version_compare(VERSION, '3.1', '<'))
		{
			return '<strong class="title">' . $this->type . '</strong>';
		}
		return '';
	}

}