<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 22.08.13
 * Time: 10:12
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\DataContainer;


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
	 * save tab changes
	 * @param $value
	 * @param $dc
	 *
	 * @return mixed
	 */
	public function saveTabs($value, $dc)
	{
		$class = $GLOBALS['TL_CTE']['bootstrap_tabs'][$dc->activeRecord->type];
		$tabs = deserialize($value, true);
		$count = 0;
		$end = false;

		// count each tabs but no dropdown
		foreach($tabs as $tab)
		{
			if($tab['type'] != 'dropdown') {
				$count++;
			}
		}

		// get all next coming content elements
		$result = $this->Database
			->prepare('SELECT id, type FROM tl_content WHERE pid=? AND ptable=? AND sorting > ? ORDER BY sorting')
			->execute($dc->activeRecord->pid, $dc->activeRecord->ptable, $dc->activeRecord->sorting);

		while($result->next())
		{
			if($result->type == $class::getName('separator'))
			{
				$count--;

				// tab sizes is reduced so delete no more needed tab part elements
				if($count < 1) {
					$model = new \ContentModel();
					$model->id = $result->id;
					$model->delete();
				}
			}

			elseif($result->type == $class::getName('stop'))
			{
				$end = $result->id;
				break;
			}
		}

		// end element exists, go fetch its sorting to append tab parts at the end
		if($end)
		{
			$end = \ContentModel::findByPk($end);
			$sorting = $end->sorting;
			$count--;
		} else
		{
			$sorting = $dc->activeRecord->sorting;
		}

		// craete new tab parts
		for($i = 0; $i < $count; $i++)
		{
			$sorting = $sorting+1;

			$model = new \ContentModel();
			$model->pid = $dc->activeRecord->pid;
			$model->ptable = $dc->activeRecord->ptable;
			$model->type = ((!$end && ($count - $i == 1)) ? $class::getName('stop') : $class::getName('separator'));
			$model->sorting = $sorting;
			$model->tstamp = time();
			$model->save();
		}

		if($end) {
			$end->sorting = $sorting+1;
			$end->save();
		}

		return $value;
	}


	/**
	 * save slider and add stop element
	 * @param $dc
	 */
	public function saveSlider($dc)
	{
		if($dc->activeRecord->type != 'bootstrap_sliderStart') {
			return;
		}

		$result = $this->Database
			->prepare('SELECT type FROM tl_content WHERE pid=? AND ptable=? AND type=? AND sorting > ? ORDER BY sorting')
			->limit(1)
			->execute($dc->activeRecord->pid, $dc->activeRecord->ptable, 'bootstrap_sliderEnd', $dc->activeRecord->sorting);

		if($result->numRows == 0)
		{
			$model = new \ContentModel();
			$model->type = 'bootstrap_sliderEnd';
			$model->ptable = $dc->activeRecord->ptable;
			$model->pid = $dc->activeRecord->pid;
			$model->sorting = $dc->activeRecord->sorting+1;
			$model->tstamp = time();
			$model->save();
		}

	}


	/**
	 * delete wrapper element deletes all elements belong to the wrapper type
	 *
	 * @param $d
	 */
	public function deleteWrapperElements($dc)
	{

		$found = false;

		foreach($GLOBALS['BOOTSTRAP']['wrappers'] as $data)
		{
			if($data['start'] == $dc->activeRecord->type)
			{
				$found = true;
				break;
			}
		}

		if(!$found)
		{
			return;
		}

		$delete = array();
		$result = $this->Database
			->prepare('SELECT type, id FROM tl_content WHERE pid=? AND ptable=? AND sorting > ? ORDER BY sorting')
			->execute($dc->activeRecord->pid, $dc->activeRecord->ptable, $dc->activeRecord->sorting);

		while($result->next())
		{

			if(in_array($result->type, $data))
			{
				$delete[] = $result->id;
			}

			if($result->type == $data['stop'])
			{
				break;
			}
		}

		if(!empty($delete))
		{
			$this->Database->query(sprintf('DELETE FROM tl_content WHERE id IN(%s)', implode(',', $delete)));
		}
	}

}