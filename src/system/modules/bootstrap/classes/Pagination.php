<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 20.08.13
 * Time: 17:19
 * To change this template use File | Settings | File Templates.
 */


class Pagination extends \Contao\Pagination
{
	/**
	 * Generate all page links separated with the given argument and return them as string
	 * @param string
	 * @return string
	 */
	public function getItemsAsString($strSeparator=' ')
	{
		return parent::getItemsAsString($strSeparator=' ');
		$arrLinks = array();

		$intNumberOfLinks = floor($this->intNumberOfLinks / 2);
		$intFirstOffset = $this->intPage - $intNumberOfLinks - 1;

		if ($intFirstOffset > 0)
		{
			$intFirstOffset = 0;
		}

		$intLastOffset = $this->intPage + $intNumberOfLinks - $this->intTotalPages;

		if ($intLastOffset < 0)
		{
			$intLastOffset = 0;
		}

		$intFirstLink = $this->intPage - $intNumberOfLinks - $intLastOffset;

		if ($intFirstLink < 1)
		{
			$intFirstLink = 1;
		}

		$intLastLink = $this->intPage + $intNumberOfLinks - $intFirstOffset;

		if ($intLastLink > $this->intTotalPages)
		{
			$intLastLink = $this->intTotalPages;
		}

		for ($i=$intFirstLink; $i<=$intLastLink; $i++)
		{
			if ($i == $this->intPage)
			{
				$arrLinks[] = sprintf('<li class="active"><span>%s</span></li>', $i);
				continue;
			}

			$arrLinks[] = sprintf('<li><a href="%s" class="link" title="%s">%s</a></li>',
				$this->linkToPage($i),
				sprintf(specialchars($GLOBALS['TL_LANG']['MSC']['goToPage']), $i),
				$i);
		}

		return implode($strSeparator, $arrLinks);
	}

}