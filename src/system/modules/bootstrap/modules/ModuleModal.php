<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 04.09.13
 * Time: 11:33
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;

class ModuleModal extends BootstrapModule
{

	/**
	 * namespaces elements
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('addModalFooter', 'buttons', 'modalContentType', 'modalTemplate', 'module', 'remoteUrl', 'text');


	/**
	 * template
	 * @var string
	 */
	protected $strTemplate = 'mod_bootstrap_modal';


	/**
	 * compile
	 */
	protected function compile()
	{
		//$this->Template->content = $this->getFrontendModule($this->module);
		switch($this->modalContentType)
		{
			case 'form':
				$GLOBALS['bootstrapModalForm'] = '';
				$this->Template->content = $this->getForm($this->form);

				if($GLOBALS['BOOTSTRAP']['modal']['adjustForm'])
				{
					$this->Template->footer = $GLOBALS['bootstrapModalForm'];
					unset($GLOBALS['bootstrapModalForm']);
				}

				break;

			case 'module':
				$this->Template->content = $this->getFrontendModule($this->module);
				break;

			case 'html':
				$this->Template->content = (TL_MODE == 'FE') ? $this->html : htmlspecialchars($this->html);
				break;

			case 'template':
				ob_start();
				include $this->getTemplate($this->modalTemplate);
				$buffer = ob_get_contents();
				ob_end_clean();

				$this->Template->content = $buffer;

				break;

			case 'text':
				$this->Template->content = \String::toHtml5($this->text);
				break;
		}

		if($this->addModalFooter)
		{
			$buttons  = new Buttons();
			$buttons->loadFromFieldset($this->buttons);
			$buttons->buttonStyle = $this->buttonStyle ? $this->buttonStyle : 'btn-default';
			$buttons->addContainer = false;

			$this->Template->footerButtons = $buttons->generate();
		}

		$this->Template->headerClose = $GLOBALS['BOOTSTRAP']['modal']['dismiss'];
	}

}