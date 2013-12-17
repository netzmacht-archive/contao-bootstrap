<?php

namespace Netzmacht\Bootstrap\Model\ContentWrapper;

use Model\Collection;

/**
 * Class Repository
 * @package Netzmacht\Bootstrap\Model\ContentWrapper
 */
class Repository
{
	/**
	 * count related elements optionally limited by type
	 *
	 * @param Model $model
	 * @param string $type
	 * @return int
	 */
	public static function countRelatedElements(Model $model, $type=null)
	{
		if($model->getType() == $model::TYPE_START) {
			if($type === null) {
				$strColumn = 'bootstrap_parentId';
				$mixedValue = $model->id;
			}
			else {
				$strColumn = 'bootstrap_parentId=? AND type';
				$mixedValue = array($model->id, $model->getTypeName($type));
			}
		}
		elseif($type === null) {
			$strColumn = 'id !=? AND (bootstrap_parentId=? OR id=?) AND 1';
			$mixedValue = array($model->id, $model->bootstrap_parentId, $model->bootstrap_parentId, 1);
		}
		elseif($type == $model::TYPE_START) {
			$strColumn = 'id';
			$mixedValue = $model->bootstrap_parentId;
		}
		else {
			$strColumn = 'id !=? AND bootstrap_parentId=? AND type';
			$mixedValue = array($model->id, $model->bootstrap_parentId, $model->getTypeName($type));

		}

		return $model->getModel()->countBy($strColumn, $mixedValue);
	}


	/**
	 * Find related elements of a start element
	 *
	 * @param Model $model
	 * @param null $type
	 *
	 * @return Collection
	 */
	public static function findRelatedElements(Model $model, $type=null)
	{
		if($model->bootstrap_parentId == '' && $model->getType() != $model::TYPE_START) {
			return null;
		}

		$database = \Database::getInstance();

		if($type === null) {
			$result = $database
				->prepare('SELECT * FROM tl_content WHERE bootstrap_parentId=? ORDER BY sorting')
				->execute($model->id);
		}
		else {
			$result = $database
				->prepare('SELECT * FROM tl_content WHERE bootstrap_parentId=? AND type=? ORDER BY sorting')
				->execute($model->id, $model->getTypeName($type));
		}

		return new Collection($result, 'tl_content');
	}


	/**
	 * Find related elements of a start element
	 *
	 * @param Model $model
	 * @param null $type
	 *
	 * @return Model
	 */
	public static function findRelatedElement(Model $model, $type=null)
	{
		if($model->bootstrap_parentId == '' && $model->getType() != $model::TYPE_START) {
			return null;
		}

		$database = \Database::getInstance();
		$parentId = $model->getType() == $model::TYPE_START ? $model->id : $model->bootstrap_parentId;

		if($type === null) {
			$result = $database
				->prepare('SELECT * FROM tl_content WHERE bootstrap_parentId=? ORDER BY sorting')
				->limit(1)
				->execute($parentId);
		}
		else {
			$result = $database
				->prepare('SELECT * FROM tl_content WHERE bootstrap_parentId=? AND type=? ORDER BY sorting')
				->limit(1)
				->execute($parentId, $model->getTypeName($type));
		}

		if(!$result->numRows) {
			return null;
		}

		return new Model(new \ContentModel($result, 'tl_content'));
	}


	/**
	 * try to find previous element of same type or specified type
	 *
	 * @param Model $model
	 * @param null $type
	 *
	 * @return \Model|null
	 */
	public static function findPreviousElement(Model $model, $type=null)
	{
		if($type === null) {
			$type = $model->getType();
		}

		$databse = \Database::getInstance();
		$result  = $databse
			->prepare('SELECT * FROM tl_content WHERE pid=? AND ptable=? AND type=? AND sorting<?')
			->limit(1)
			->execute($model->pid, $model->ptable, $model->getTypeName($type), $model->sorting);

		if($result) {
			return new Model(new \ContentModel($result));
		}

		return null;
	}
}
