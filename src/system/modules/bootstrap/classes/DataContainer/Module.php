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

namespace Netzmacht\Bootstrap\DataContainer;

use Netzmacht\Bootstrap\DataContainer\General;

/**
 * Class ModuleDataContainer
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Module extends General
{

	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->import('BackendUser', 'User');
	}

	/**
	 * Get all articles and return them as array
	 * @param \DataContainer
	 * @return array
	 */
	public function getAllArticles(\DataContainer $dc)
	{
		$arrPids = array();
		$arrArticle = array();

		// Limit pages to the user's pagemounts
		if ($this->User->isAdmin)
		{
			$objArticle = $this->Database->execute("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid ORDER BY parent, a.sorting");
		}
		else
		{
			foreach ($this->User->pagemounts as $id)
			{
				$arrPids[] = $id;
				$arrPids = array_merge($arrPids, $this->Database->getChildRecords($id, 'tl_page'));
			}

			if (empty($arrPids))
			{
				return $arrArticle;
			}

			$objArticle = $this->Database->execute("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid WHERE a.pid IN(". implode(',', array_map('intval', array_unique($arrPids))) .") ORDER BY parent, a.sorting");
		}

		// Edit the result
		if ($objArticle->numRows)
		{
			$this->loadLanguageFile('tl_article');

			while ($objArticle->next())
			{
				$key = $objArticle->parent . ' (ID ' . $objArticle->pid . ')';
				$arrArticle[$key][$objArticle->id] = $objArticle->title . ' (' . ($GLOBALS['TL_LANG']['tl_article'][$objArticle->inColumn] ?: $objArticle->inColumn) . ', ID ' . $objArticle->id . ')';
			}
		}

		return $arrArticle;
	}


}