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

namespace Netzmacht\Bootstrap\Model\Collection;

/**
 * Class ContentWrapperCollection
 * @package Netzmacht\Bootstrap
 */
class ContentWrapper extends \Model\Collection
{

	/**
	 * Fetch the next result row and create the model
	 *
	 * @return boolean True if there was another row
	 */
	protected function fetchNext()
	{
		if ($this->objResult->next() == false)
		{
			return false;
		}

		$strClass = 'Bootstrap\Model\ContentWrapper';
		$this->arrModels[$this->intIndex + 1] = new $strClass($this->objResult);

		return true;
	}

}