<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 29.08.13
 * Time: 12:38
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\ContentElement;

/**
 * Class ContentAccordionGroup
 * @package Netzmacht\Bootstrap
 */
class ContentAccordionGroup extends Wrapper
{

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_accordion_group';


	/**
	 * compile accordion group
	 */
	protected function compile()
	{
		if($this->objModel->getType() == ContentWrapperModel::TYPE_START)
		{
			$GLOBALS['accordionGroup'] = 'accordion-group-' . $this->id;
			$GLOBALS['accordionGroupFirst'] = true;
			$this->Template->groupId = $GLOBALS['accordionGroup'];
		}
		else
		{
			$GLOBALS['accordionGroup'] = null;
			$GLOBALS['accordionGroupFirst'] = null;
		}
	}
}