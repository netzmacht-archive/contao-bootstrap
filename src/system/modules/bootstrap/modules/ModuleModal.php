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
	protected $arrBootstrapAttributes = array('addModalBody', 'addModalFooter', 'addCloseButton', 'buttons', 'closeButton', 'modalContentType', 'module', 'text');

	protected $strTemplate = 'mod_bootstrap_modal';

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

			case 'text':
				$this->Template->content = \String::toHtml5($this->text);
				break;
		}

		if($this->addModalFooter)
		{
			$buttons  = new Buttons();
			$buttons->loadFromFieldset($this->buttons);

			$buttonsTemplate = new \FrontendTemplate('bootstrap_buttons');
			$buttonsTemplate->buttonStyle = $this->buttonStyle ? $this->buttonStyle : 'btn-default';

			if($this->addCloseButton)
			{
				$inject = array
				(
					'type'       => 'link',
					'button'     => 'button',
					'label'      => $this->closeButton ? $this->closeButton : $GLOBALS['TL_LANG']['MSC']['close'],
					'value'      => '',
					'attributes' => 'data-dismiss="modal"',
				);

				$buttons->addItem($inject, true, true);
			}

			$buttonsTemplate->addContainer = false;
			$buttonsTemplate->buttons = $buttons;
			$buttonsTemplate->containerClass = 'btn-' . $buttons->getContainerType();

			$this->Template->footerButtons = $buttonsTemplate->parse();
		}

		$this->Template->headerClose = $GLOBALS['BOOTSTRAP']['modal']['dismiss'];
	}

}