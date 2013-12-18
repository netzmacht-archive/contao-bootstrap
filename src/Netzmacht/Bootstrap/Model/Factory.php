<?php

namespace Netzmacht\Bootstrap\Model;

use Database\Result;

/**
 * Class Locator
 * @package Netzmacht\Bootstrap\Model
 */
class Factory
{

	/**
	 * @param \Database\Result|int $result Result object or id
	 * @param string $table
	 * @param bool $update Update model to current result if model is in the registry
	 *
	 * @return \Model
	 */
	public static function create($result, $table, $update=false)
	{
		$class = \Model::getClassFromTable($table);
		$model = null;

		$id    = is_object($result) ? $result->id : $result;

		// Check the registry in Contao 3.2
		if(version_compare(VERSION, '3.2', '>=')) {
			$model = \Model\Registry::getInstance()->fetch($table, $id);

			// model is already in the registry, shall we update the model to the current record?
			// This will affect every reference which is used
			// You really have to know what u need - both can be dangerous
			if($model && $update) {
				$model->setRow($result->row());
			}
		}

		// Model is not in the registry
		if(!$model) {
			if(is_object($result)) {
				$model = new $class($result);
			}
			else {
				$model = new $class();
				$model->id = $id;
			}
		}

		return $model;
	}

} 