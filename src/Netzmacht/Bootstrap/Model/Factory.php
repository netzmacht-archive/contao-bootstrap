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
		$model = null;
		$class = \Model::getClassFromTable($table);
		$id    = is_object($result) ? $result->id : $result;
		$cto32 = version_compare(VERSION, '3.2', '>=');

		// Check the registry in Contao 3.2
		if($cto32) {
			$model = \Model\Registry::getInstance()->fetch($table, $id);

			// model is already in the registry, shall we update the model to the current record?
			// This will affect every reference which uses the model
			// You really have to know what u need - both is dangerous
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
				// we have to get the result from the db
				$result = \Database::getInstance()
					->prepare("SELECT * FROM $table WHERE id=?")
					->execute($id);

				if($result->numRows) {
					$model = new $class($result);
				}
				else {
					$model = new $class();

					// do not set id if Contao 3.2 is used because a new record is created, so that id is ignored
					if(!$cto32) {
						$model->id = $id;
					}
				}
			}
		}

		return $model;
	}

}
