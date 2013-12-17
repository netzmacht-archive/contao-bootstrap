<?php

namespace Netzmacht\Bootstrap\Model;

use Database\Result;

/**
 * Class Locator
 * @package Netzmacht\Bootstrap\Model
 */
class Locator
{

	/**
	 * @param $result
	 * @param $table
	 *
	 * @return \Model
	 */
	public static function resolve($result, $table)
	{
		$class = \Model::getClassFromTable($table);
		$model = null;
		$id    = is_object($result) ? $result->id : $result;

		// first check the registry
		if(version_compare(VERSION, '3.2', '>=')) {
			$model = \Model\Registry::getInstance()->fetch($table, $id);

			if(!$model) {
				$model = $class::findByPk($id);

				if($model) {
					$model->setRow($result->row());
				}
			}
		}

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