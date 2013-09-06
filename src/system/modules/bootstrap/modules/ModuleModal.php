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

namespace Netzmacht\Bootstrap;

class ModuleModal extends BootstrapModule
{

	/**
	 * namespaces elements
	 * @var array
	 */
	protected $arrBootstrapAttributes = array(
		'addModalFooter',
		'article',
		'buttons',
		'modalAjax',
		'modalContentType',
		'modalDynamicContent',
		'modalTemplate',
		'module',
		'remoteUrl',
		'text'
	);


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
		// check if ajax is used
		if($this->modalAjax)
		{
			$this->Template->hideFrame = (bool) $this->isAjax;
			$this->Template->hideContent = !$this->Template->hideFrame;
		}

		if($this->Template->hideContent)
		{
			$url = sprintf($GLOBALS['BOOTSTRAP']['modal']['remoteUrl'], $GLOBALS['objPage']->id, $this->id);
			$this->Template->dataRemote = ' data-remote="' . $url . '"';
			return;
		}

		// load dynamic content
		elseif($this->isAjax && $this->modalDynamicContent)
		{
			$dynamic = \Input::get('dynamic');

			if($dynamic != '' && in_array($dynamic, array('article', 'module', 'form')))
			{
				$this->{$dynamic} = \Input::get('id');
				$this->modalContentType = $dynamic;

			}
		}

		switch($this->modalContentType)
		{
			case 'article':
				$this->Template->content = $this->getArticle($this->article, false, true);
				break;

			case 'form':
				$GLOBALS['bootstrapModalForm'] = '';
				$this->Template->content = $this->getForm($this->form);

				if($GLOBALS['BOOTSTRAP']['modal']['adjustForm'])
				{
					$this->Template->footer = $GLOBALS['bootstrapModalForm'];
					unset($GLOBALS['bootstrapModalForm']);
				}

				// render style select if it is used
				if($this->isAjax && $GLOBALS['BOOTSTRAP']['form']['styleSelect']['enabled'])
				{
					$this->Template->content .= sprintf(
						'<script>$(\'.%s\').selectpicker(\'render\');</script>',
						$GLOBALS['BOOTSTRAP']['form']['styleSelect']['class']
					);
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

			$this->Template->footerButtons = $buttons;
		}

		$this->Template->headerClose = $GLOBALS['BOOTSTRAP']['modal']['dismiss'];
	}

}