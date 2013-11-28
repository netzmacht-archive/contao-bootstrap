<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 15.09.13
 * Time: 17:01
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\Template\Modifier;


class Panel
{

	/**
	 * @param \Template $template
	 */
	public static function setPanelDefaultClass(\Template $template)
	{
		$classes = array(
			'accordionStart' => 'ce_accordionStart',
			'accordionSingle' => 'ce_accordionSingle',
		);

		if($template->class != $classes[$template->type])
		{
			return;
		}

		switch($template->type)
		{
			case 'accordionStart':
			case 'accordionSingle':
				$template->class = $template->class . ' panel-default';
				break;
		}
	}

}