<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 21.08.13
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


class FormButton extends \FormSubmit
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

			if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
			{
				return sprintf('<button type="submit" id="ctrl_%s" class="submit%s" title="%s" alt="%s"%s>%s</button>',
					$this->strId,
					(($this->strClass != '') ? ' ' . $this->strClass : ''),
					specialchars($this->slabel),
					specialchars($this->slabel),
					$this->getAttributes(),
					$this->generateImage($objModel->path, $this->slabel)
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
		return sprintf('<button type="submit" id="ctrl_%s" class="submit%s"%s>%s</button>',
			$this->strId,
			(($this->strClass != '') ? ' ' . $this->strClass : ''),
			$this->getAttributes(),
			$label
		);
	}

}