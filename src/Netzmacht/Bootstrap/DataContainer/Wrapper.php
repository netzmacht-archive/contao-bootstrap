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
use Netzmacht\Bootstrap\Model\Factory;


/**
 * Class WrapperDataContainer
 *
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Wrapper extends \Backend
{

	/**
	 * @var int
	 */
	const TRIGGER_CREATE = 1;

	/**
	 * @var int
	 */
	const TRIGGER_DELETE = 2;

	/**
	 * order const ascending
	 */
	const ORDER_ASC = 'asc';

	/**
	 * order const descending
	 */
	const ORDER_DESC = 'desc';


	/**
	 * current model
	 *
	 * @var ContentWrapper\Model
	 */
	protected $objModel;


	/**
	 * Try to create wrapper elements, triggered by save_callback of type field
	 * @param $value
	 * @param $dc
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function save($value, $dc)
	{
		// shortcuts
		$start  = ContentWrapper\Model::TYPE_START;
		$stop   = ContentWrapper\Model::TYPE_STOP;
		$sep    = ContentWrapper\Model::TYPE_SEPARATOR;

		$model = new \ContentModel();
		$model->setRow($dc->activeRecord->row());
		$model->type = $value;

		$this->objModel = new ContentWrapper\Model($model);
		$sorting = $this->objModel->sorting;

		// getType will throw an exception if type is not found. use it to detect non content wrapper elements
		try {
			$type = $this->objModel->getType();
		}
		catch(\Exception $e)
		{
			return $value;
		}

		// check for existing parent element and try to create it if not existing
		if($type != $start) {
			if($this->objModel->bootstrap_parentId == '') {
				$parent = ContentWrapper\Repository::findPreviousElement($this->objModel, $start);

				if($parent) {
					// set relation to parent element
					$this->objModel->bootstrap_parentId = $parent->id;

					$end = ContentWrapper\Repository::findRelatedElement($this->objModel, $stop);

					if($end === null) {
						$this->objModel->sorting = $parent->sorting + 2;
					}
					elseif($parent !== null && $parent->sorting > $end->sorting) {
						$this->objModel->sorting = $end->sorting - 2;
					}

					// set relation to parent element
					if($this->objModel->getType() != $start) {
						$this->objModel->bootstrap_parentId = $parent->id;
					}

					$this->objModel->getModel()->save();
				}

				// create parent if possible
				elseif($this->isTrigger($type, $start)) {
					$sorting = $sorting-2;
					$this->createElement($sorting, $start);
				}

				// no parent element exists, throw error
				else
				{
					throw new \Exception(sprintf(
						$GLOBALS['TL_LANG']['ERR']['wrapperStartNotExists'],
						$GLOBALS['TL_LANG']['CTE'][$value][0] ?: $value
					));
				}
			}
		}

		// create separators if possible
		if($type != $sep && ($this->isTrigger($type, $sep) || $this->isTrigger($type, $sep, static::TRIGGER_DELETE)))
		{
			$config   = $GLOBALS['BOOTSTRAP']['wrappers'][$this->objModel->getGroup()][$sep];
			$callback = $config['countExisting'];
			$this->import($callback[0]);
			$existing = $this->$callback[0]->$callback[1]($this->objModel);

			$callback = $config['countRequired'];
			$this->import($callback[0]);
			$required = $this->$callback[0]->$callback[1]($this->objModel);

			if($existing < $required)
			{
				if($this->isTrigger($type, $sep))
				{
					$count = $required - $existing;

					for($i = 0; $i < $count; $i++)
					{
						$this->createElement($sorting, $sep);
					}

					$end = ContentWrapper\Repository::findRelatedElement($this->objModel, $stop);

					if($end && $end->sorting <= $sorting) {
						$sorting = $sorting + 2;
						$end->sorting = $sorting;
						$end->getModel()->save();
					}
				}
			}
			elseif($required < $existing)
			{
				if($this->isTrigger($type, $sep, static::TRIGGER_DELETE))
				{
					$count = $existing - $required;

					$parentId = $this->objModel->getType() == ContentWrapper\Model::TYPE_START
						? $this->objModel->id
						: $this->objModel->bootstrap_parentId;

					$this->Database
						->prepare('DELETE FROM tl_content WHERE bootstrap_parentId=? AND type=? ORDER BY sorting DESC')
						->limit($count)
						->execute($parentId, $this->objModel->getTypeName($sep));
				}
			}
		}

		// cereate end element
		if($type == $start && $this->isTrigger($type, $stop))
		{
			$end = ContentWrapper\Repository::countRelatedElements($this->objModel, $stop);

			if(!$end) {
				$end = $this->createElement($sorting, $stop);
			}
		}

		return $value;
	}


	/**
	 * handle content element deletion, called by ondelete_callback
	 * @param $dc
	 */
	public function delete($dc)
	{
		$model = \ContentModel::findByPk($dc->id);
		$this->objModel = new ContentWrapper\Model($model);

		// getType will throw an exception if type is not found. use it to detect non content wrapper elements
		try {
			$type = $this->objModel->getType();
		}
		catch(\Exception $e)
		{
			return;
		}

		if($this->objModel->getType() == ContentWrapper\Model::TYPE_START)
		{
			$deleteTypes = array();

			if($this->isTrigger($this->objModel->getType(), ContentWrapper\Model::TYPE_SEPARATOR, static::TRIGGER_DELETE)) {
				$deleteTypes[] = $this->objModel->getTypeName(ContentWrapper\Model::TYPE_SEPARATOR);
			}

			if($this->isTrigger($this->objModel->getType(), ContentWrapper\Model::TYPE_STOP, static::TRIGGER_DELETE)) {
				$deleteTypes[] = $this->objModel->getTypeName(ContentWrapper\Model::TYPE_STOP);
			}

			if(!empty($deleteTypes)) {
				$this->Database
					->prepare(sprintf(
						'DELETE FROM tl_content WHERE bootstrap_parentId=? AND type IN(\'%s\')',
						implode('\',\'', $deleteTypes)
					))
					->execute($this->objModel->id);
			}
		}
		elseif($this->objModel->getType() == ContentWrapper\Model::TYPE_STOP) {
			if($this->isTrigger($this->objModel->getType(), ContentWrapper\Model::TYPE_SEPARATOR, static::TRIGGER_DELETE)) {
				$this->Database
					->prepare('DELETE FROM tl_content WHERE bootstrap_parentId=? AND type=?')
					->execute(
						$this->objModel->bootstrap_parentId,
						$this->objModel->getTypeName(ContentWrapper\Model::TYPE_SEPARATOR)
					);
			}

			if($this->isTrigger($this->objModel->getType(), ContentWrapper\Model::TYPE_START, static::TRIGGER_DELETE)) {
				$query = sprintf('DELETE FROM %s WHERE id=?', $this->objModel->getModel()->getTable());

				\Database::getInstance()
					->prepare($query)
					->execute($this->objModel->bootstrap_parentId);
			}
		}
		else {
			// todo: handle seperator delete actions
		}
	}


	/**
	 * Create a new wrapper element
	 *
	 * @param int                 $sorting
	 * @param string              $type
	 *
	 * @return ContentWrapper\Model
	 */
	protected function createElement(&$sorting, $type=ContentWrapper\Model::TYPE_SEPARATOR)
	{
		$model = new \ContentModel();

		if($type == ContentWrapper\Model::TYPE_START) {
			$sorting = $sorting - 2;
		}
		else {
			$sorting = $sorting + 2;
			$model->bootstrap_parentId = $this->objModel->id;
		}

		$model->tstamp  = time();
		$model->pid     = $this->objModel->pid;
		$model->ptable  = $this->objModel->ptable;
		$model->type    = $this->objModel->getTypeName($type);
		$model->sorting = $sorting;

		$model->save();

		return $model;
	}


	/**
	 * check if action can be triggered
	 *
	 * @param string $trigger
	 * @param string $target
	 * @param int    $action
	 *
	 * @return bool
	 */
	protected function isTrigger($trigger, $target, $action = Wrapper::TRIGGER_CREATE)
	{
		$config  = $GLOBALS['BOOTSTRAP']['wrappers'][$this->objModel->getGroup()];
		$key = $action == static::TRIGGER_DELETE ? 'triggerDelete' : 'triggerCreate';

		if(isset($config[$trigger][$key]) && $config[$trigger][$key])
		{
			$key = $action == static::TRIGGER_DELETE ? 'autoDelete' : 'autoCreate';

			// check if count callback is defined
			if($target == ContentWrapper\Model::TYPE_SEPARATOR)
			{
				if(!isset($config[$target]['countExisting']) || !isset($config[$target]['countRequired']))
				{
					return false;
				}
			}

			return(isset($config[$target][$key]) && $config[$target][$key]);
		}

		return false;
	}

}