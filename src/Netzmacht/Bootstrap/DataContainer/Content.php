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

use Netzmacht\Bootstrap\Model\ContentWrapper;

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
	 * @param ContentWrapper\Model $model
	 *
	 * @return int
	 */
	public function countExistingTabSeparators(ContentWrapper\Model $model)
	{
		$id = $model->getType() == ContentWrapper\Model::TYPE_START ? $model->id : $model->bootstrap_parentId;

		$number = \ContentModel::countBy(
			'type=? AND bootstrap_parentId',
			array($model->getTypeName(ContentWrapper\Model::TYPE_SEPARATOR), $id)
		);

		return $number;
	}

	/**
	 * count required tab separator elements
	 *
	 * @param ContentWrapper\Model $model
	 *
	 * @return int
	 */
	public function countRequiredTabSeparators(ContentWrapper\Model $model)
	{
		if($model->getType() != ContentWrapper\Model::TYPE_START) {
			$model = \ContentModel::findByPk($model->bootstrap_parentId);
		}

		$tabs = array();

		if($model->bootstrap_tabs) {
			$tabs = deserialize($model->bootstrap_tabs, true);
		}
		elseif(\Input::post('bootstrap_tabs')) {
			$tabs = \Input::post('bootstrap_tabs');
		}

		$count = 0;

		foreach($tabs as $tab) {
			if($tab['type'] != 'dropdown') {
				$count++;
			}
		}

		return $count > 0 ? ($count - 1 ) : 0;
	}

}