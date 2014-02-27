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
				$column = 'bootstrap_parentId';
				$values = $model->id;
			}
			else {
				$column = array('bootstrap_parentId=?', 'type=?');
				$values = array($model->id, $model->getTypeName($type));
			}
		}
		elseif($type === null) {
			$column = array('id !=?', '(bootstrap_parentId=? OR id=?)');
			$values = array($model->id, $model->bootstrap_parentId, $model->bootstrap_parentId);
		}
		elseif($type == $model::TYPE_START) {
			$column = 'id';
			$values = $model->bootstrap_parentId;
		}
		else {
			$column = array('id !=?', 'bootstrap_parentId=?', 'type=?');
			$values = array($model->id, $model->bootstrap_parentId, $model->getTypeName($type));

		}

		return \ContentModel::countBy($column, $values);
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

		$options = array(
			'order' => 'sorting'
		);

		if($type === null) {
			$column   = 'bootstrap_parentId';
			$values[] = $model->id;
		}
		else {
			$column   = array('bootstrap_parentId=? ', 'type=?');
			$values[] = $model->id;
			$values[] = $model->getTypeName($type);

		}

		return \ContentModel::findBy($column, $values, $options);
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

		$options = array(
			'order' => 'sorting'
		);

		if($type === null) {
			$column   = 'bootstrap_parentId';
			$values[] = $model->id;
		}
		else {
			$column   = array('bootstrap_parentId=? ', 'type=?');
			$values[] = $model->id;
			$values[] = $model->getTypeName($type);

		}

		return \ContentModel::findOneBy($column, $values, $options);
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

		$column = array('pid=?', 'ptable=?', 'type=?', 'sorting<?');
		$values = array($model->pid, $model->ptable, $model->getTypeName($type), $model->sorting);

		return \ContentModel::findOneBy($column, $values);
	}
}
