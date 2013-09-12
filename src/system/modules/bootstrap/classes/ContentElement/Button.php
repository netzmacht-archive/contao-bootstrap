<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 09.08.13
 * Time: 09:03
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\ContentElement;

use Netzmacht\Bootstrap\Helper\Icons;

/**
 * Class ContentButton
 * @package Netzmacht\Bootstrap
 */
class Button extends BootstrapAbstract
{

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('icon', 'dataAttributes');

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

		if ($this->linkTitle == '')
		{
			$this->linkTitle = $this->url;
		}

		if (strncmp($this->rel, 'lightbox', 8) !== 0)
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
			$this->Template->target = ' target="_blank"';
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

		// add data attributes
		$this->dataAttributes = deserialize($this->dataAttributes, true);

		if(!empty($this->dataAttributes))
		{
			$attributes = array();

			foreach($this->dataAttributes as $attribute)
			{
				if(trim($attribute['value']) != '' && $attribute['name'] != '')
				{

					$attributes[] = 'data-' . $attribute['name'] . '=' . $attribute['value'];
				}
			}

			$this->Template->attribute = trim($this->attribute . ' ' . implode(' ', $attributes));
		}

		$this->Template->rel = $this->rel; // Backwards compatibility
		$this->Template->href = $this->url;
		$this->Template->link = $this->linkTitle;
		$this->Template->linkTitle = specialchars($this->titleText ?: $this->linkTitle);
	}

}