<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 22.08.13
 * Time: 10:12
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\DataContainer;


use Netzmacht\Bootstrap\ContentWrapperModel;

class Content extends \Backend
{
	protected $articles;

	public function setArticlesRows($dc)
	{
		$element = \ContentModel::findByPk($dc->id);

		$GLOBALS['TL_DCA']['tl_content']['fields']['bootstrap_columnset']['eval']['minCount'] = $element->sc_type;
	}

	/**
	 * @param $mcw
	 * @return array
	 */
	public function getPageBootstrapArticles($mcw)
	{
		if($this->articles === null) {
			//var_dump($dc);
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
	 * @param ContentWrapperModel $model
	 *
	 * @return int
	 */
	public function countExistingTabSeparators(ContentWrapperModel $model)
	{
		$id = $model->getType() == ContentWrapperModel::TYPE_START ? $model->id : $model->bootstrap_parentId;

		return ContentWrapperModel::countBy(
			'type=? AND bootstrap_parentId',
			array($model->getTypeName(ContentWrapperModel::TYPE_SEPARATOR), $id)
		);
	}

	/**
	 * @param ContentWrapperModel $model
	 *
	 * @return int
	 */
	public function countRequiredTabSeparators(ContentWrapperModel $model)
	{
		if($model->getType() != ContentWrapperModel::TYPE_START)
		{
			$model = ContentWrapperModel::findByPk($model->bootstrap_parentId);
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