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

namespace Netzmacht\Bootstrap\Template\Modifier;

use Netzmacht\Bootstrap\Bootstrap;


/**
 * Class Elements contains modifier for content elements
 * @package Netzmacht\Bootstrap\Template\Modifier
 */
class Elements
{
	/**
	 * @param \Template $template
	 */
	public static function replaceImageClasses(\Template $template)
	{
		if (empty($template->imgSize)) {
			return;
		}

		$cssClasses   = $template->class;
		$cssClasses   = trimsplit(' ', $cssClasses);
		$imageClasses = array();

		foreach ($cssClasses as $index => $cssClass) {
			if (substr($cssClass, 0, 4) == 'img-') {
				$imageClasses[] = $cssClass;
				unset($cssClasses[$index]);
			}
		}

		if (count($imageClasses)) {
			$template->class = implode(' ', $cssClasses);
			$template->imgSize .= sprintf(' class="%s"', implode(' ', $imageClasses));
		}
	}
}