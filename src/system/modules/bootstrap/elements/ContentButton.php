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
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('icon');

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_button';


	/**
	 * compile button element, inspired by ContentHyperlink
	 */
	protected function compile()
	{
		if (substr($this->url, 0, 7) == 'mailto:')
		{
			$this->url = \String::encodeEmail($this->url);
		}
		else
		{
			$this->url = ampersand($this->url);
		}

		$embed = explode('%s', $this->embed);

		if ($this->linkTitle == '')
		{
			$this->linkTitle = $this->url;
		}

		if (strncmp($this->rel, 'lightbox', 8) !== 0 || $objPage->outputFormat == 'xhtml')
		{
			$this->Template->attribute = ' rel="'. $this->rel .'"';
		}
		else
		{
			$this->Template->attribute = ' data-lightbox="'. substr($this->rel, 9, -1) .'"';
		}

		// Override the link target
		if ($this->target)
		{
			$this->Template->target = ($objPage->outputFormat == 'xhtml') ? ' onclick="return !window.open(this.href)"' : ' target="_blank"';
		}

		if($this->cssID[1] == '')
		{
			$cssID = $this->cssID;
			$cssID[1] = 'btn-default';
			$this->cssID = $cssID;
		}

		if($this->icon)
		{
			$this->Template->icon = Icons::generateIcon($this->icon);
		}

		$this->Template->rel = $this->rel; // Backwards compatibility
		$this->Template->href = $this->url;
		$this->Template->link = $this->linkTitle;
		$this->Template->linkTitle = specialchars($this->titleText ?: $this->linkTitle);
		$this->Template->target = '';
	}

}