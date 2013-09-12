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

use Netzmacht\Bootstrap\Model;

/**
 * Class Content
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Content extends General
{

	/**
	 * @var array
	 */
	protected $articles;


	/**
	 * set number of rows for bootstrap_columnset
	 * @param $dc
	 */
	public function setArticlesRows($dc)
	{
		$element = \ContentModel::findByPk($dc->id);

		$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_columnset']['eval']['minCount'] = $element->sc_type;
	}

	/**
	 * get all articles in bootstrap section of an article
	 *
	 * @param $mcw
	 * @return array
	 */
	public function getPageBootstrapArticles($mcw)
	{
		if($this->articles === null)
		{
			$article = \ArticleModel::findByPk($mcw->activeRecord->pid);

			$model = \ArticleModel::findAll(array(
				'column' => 'pid =? AND inColumn',
				'value'  => array($article->pid, 'bootstrap'),
			));

			$articles = array();

			if($model === null) {
				return $articles;
			}

			while($model->next()) {
				$articles[$model->id] = $model->title;
			}

			$this->articles = $articles;
		}

		return $this->articles;
	}


	/**
	 * count existing tab separators elements
	 *
	 * @param Model\ContentWrapper $model
	 *
	 * @return int
	 */
	public function countExistingTabSeparators(Model\ContentWrapper $model)
	{
		$id = $model->getType() == Model\ContentWrapper::TYPE_START ? $model->id : $model->bootstrap_parentId;

		return Model\ContentWrapper::countBy(
			'type=? AND bootstrap_parentId',
			array($model->getTypeName(Model\ContentWrapper::TYPE_SEPARATOR), $id)
		);
	}

	/**
	 * count required tab separator elements
	 *
	 * @param Model\ContentWrapper $model
	 *
	 * @return int
	 */
	public function countRequiredTabSeparators(Model\ContentWrapper $model)
	{
		if($model->getType() != Model\ContentWrapper::TYPE_START)
		{
			$model = Model\ContentWrapper::findByPk($model->bootstrap_parentId);
		}

		$tabs = deserialize($model->bootstrap_tabs, true);
		$count = 0;

		foreach($tabs as $tab)
		{
			if($tab['type'] != 'dropdown')
			{
				$count++;
			}
		}

		return $count > 0 ? ($count - 1 ) : 0;
	}

}