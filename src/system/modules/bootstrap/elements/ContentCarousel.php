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


class ContentCarousel extends BootstrapWrapperElement
{

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('autostart', 'interval', 'showIndicators', 'showControls');

	protected $strTemplate = 'ce_bootstrap_carousel';

	protected $strIdentifier = 'carousel-%s';



	/**
	 * compile wrapper element
	 */
	protected function compile()
	{
		// get included elements
		if($this->objModel->getType() == ContentWrapperModel::TYPE_START)
		{
			$this->Template->count = $this->objModel->countRelatedElements() + 1;

			$cssID = $this->cssID;

			if($cssID[0] == '')
			{
				$cssID[0] = sprintf($this->strIdentifier, $this->id);
				$this->cssID = $cssID;
			}
		}

		// generate css identifier
		else
		{
			$start = $this->objModel->findRelatedelements(ContentWrapperModel::TYPE_START);

			if($start !== null)
			{
				$this->Template->start = $start;

				$start['cssID'] = deserialize($start['cssID'], true);

				if($start['cssID'][0] == '')
				{
					$start['cssID'][0] = sprintf($this->strIdentifier, $start['id']);
					$this->cssID = $start['cssID'];
				}
				else
				{
					$this->cssID = $start['cssID'];
				}
			}
		}


		$this->Template->identifier = $this->cssID[0];
		parent::compile();
	}

}