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


class ContentSlider extends BootstrapWrapperElement
{

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('subType', 'autostart', 'interval', 'showIndicators', 'showControls');

	/**
	 * @var string
	 */
	protected static $strWrapperName = 'slider';

	protected $strTemplate = 'ce_bootstrap_slider';

	protected $strIdentifier = 'carousel-%s';


	/**
	 * compile wrapper element
	 */
	protected function compile()
	{
		// get included elements
		if($this->type == static::getName('start'))
		{
			$count = 1;
			$result = $this->Database
				->prepare('SELECT type FROM tl_content WHERE pid=? AND ptable=? AND sorting > ? ORDER BY sorting')
				->execute($this->pid, $this->ptable, $this->sorting);

			while ($result->next())
			{

				if($result->type == self::getName('stop'))
				{
					break;
				}
				elseif($result->type == self::getName('separator'))
				{
					$count++;
				}
			}

			$this->Template->count = $count;
		}

		// generate css identifier
		if($this->type != static::getName('start'))
		{
			$start = self::getStartElement();
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
		elseif($this->cssID[0] == '')
		{
			$cssID = $this->cssID;
			$cssID[0] = sprintf($this->strIdentifier, $this->id);
			$this->cssID = $cssID;
		}

		$this->Template->identifier = $this->cssID[0];

		parent::compile();
	}

}