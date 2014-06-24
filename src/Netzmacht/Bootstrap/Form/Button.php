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

namespace Netzmacht\Bootstrap\Form;


use Netzmacht\Bootstrap\Helper\Icons;

class Button extends \FormSubmit
{
	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		if ($this->imageSubmit)
		{
			// Check for version 3 format
			if ($this->singleSRC != '' && !is_numeric($this->singleSRC))
			{
				return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
			}

			$objModel = \FilesModel::findByPk($this->singleSRC);

			if(version_compare(VERSION, '3.2', '<')) {
				$image = $objModel->id;
			}
			else {
				$image = $objModel->uuid;
			}

			if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
			{
				return sprintf('<button type="submit" id="ctrl_%s" class="submit %s" title="%s" alt="%s"%s>%s</button>',
					$this->strId,
					(($this->strClass != '') ? ' ' . $this->strClass : 'btn-default'),
					specialchars($this->slabel),
					specialchars($this->slabel),
					$this->getAttributes(),
					\Image::getHtml($image, $this->slabel)
				);
			}


		}

		$label = specialchars($this->slabel);

		if($this->bootstrap_addIcon) {
			$icon = Icons::generateIcon($this->bootstrap_icon);

			if($this->bootstrap_iconPosition == 'right') {
				$label = $label . ' ' . $icon;
			}
			else {
				$label = $icon  . ' ' . $label;
			}
		}

		// Return the regular button
		return sprintf('<button type="submit" id="ctrl_%s" class="submit btn %s"%s>%s</button>',
			$this->strId,
			(($this->strClass != '') ? $this->strClass : 'btn-default'),
			$this->getAttributes(),
			$label
		);
	}

}