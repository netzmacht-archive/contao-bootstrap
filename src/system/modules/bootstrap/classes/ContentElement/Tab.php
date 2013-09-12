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

namespace Netzmacht\Bootstrap\ContentElement;

use Netzmacht\Bootstrap\Model\ContentWrapper;

/**
 * Class ContentTab
 *
 * @package Netzmacht\Bootstrap
 */
class Tab extends Wrapper
{

	/**
	 * @var string
	 */
	protected $strTemplate = 'ce_bootstrap_tab';

	/**
	 * @var array
	 */
	protected $arrBootstrapAttributes = array('fade', 'tabs');

	protected $arrTabdefinition;

	protected $arrTabs;
	protected $arrTab;


	/**
	 * prepare tab content element
	 * @param $objElement
	 */
	public function __construct($objElement)
	{
		parent::__construct($objElement);

		// load tab definitions
		if($this->objModel->getType() == ContentWrapper::TYPE_START)
		{
			$tabs = deserialize($this->tabs, true);
			$tab = null;

			foreach ($tabs as $i => $t)
			{
				$tabs[$i]['id'] = standardize($t['title']);

				if($t['type'] != 'dropdown' && $tab === null)
				{
					$tab = $tabs[$i];
				}
			}

			$this->arrTabs = $tabs;
			$this->arrTab = $tab;
			$this->fade = $this->bootstrap_fade;
		}
		elseif($this->objModel->getType() == ContentWrapper::TYPE_SEPARATOR)
		{
			$elements = $this->Database
				->prepare('SELECT id FROM tl_content WHERE bootstrap_parentId=? ORDER by sorting')
				->execute($this->bootstrap_parentId);

			$elements = array_merge(array($this->bootstrap_parentId), $elements->fetchEach('id'));

			$index = 0;
			$parent = ContentWrapper::findByPK($this->bootstrap_parentId);
			$tabs = deserialize($parent->bootstrap_tabs, true);

			foreach ($tabs as $i => $t)
			{
				$tabs[$i]['id'] = standardize($t['title']);

				if($t['type'] != 'dropdown')
				{
					if($elements[$index] == $this->id)
					{
						$this->arrTab = $tabs[$i];
					}
					$index++;
				}
			}

			$this->arrTabs = $tabs;
			$this->fade = $parent->bootstrap_fade;
		}

	}

	/**
	 * compile tabs
	 */
	protected function compile()
	{
		$this->Template->tabs = $this->arrTabs;
		$this->Template->currentTab = $this->arrTab;
	}


	/**
	 * @return string
	 */
	protected function generateTitle()
	{
		if($this->arrTab['title'] != '') {
			return '<strong class="title">' . $this->arrTab['title'] . '</strong>';
		}
	}
}