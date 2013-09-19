<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 18.09.13
 * Time: 13:40
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\DataContainer;

use DcGeneral\Data\DCGE;
use DcGeneral\DC_General;


/**
 * Class Bootstrap
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Bootstrap extends General
{

	/**
	 * @param array $values
	 * @param DC_General $dc
	 * @return array
	 * @throws \RuntimeException
	 */
	public function loadAssociativeForMcw($values, DC_General $dc)
	{
		$arrNew = array();
		$arrKeys = array_keys($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['columnFields']);

		$arrConfig = $dc->getDCA();
		$length = count($arrKeys);

		foreach((array)$values as $key => $value)
		{
			$arrRow = array
			(
				$arrKeys[0] => $key,
			);

			if($arrConfig['fields'][$dc->field]['eval']['multiColumns'])
			{
				for($i=1; $i<$length; $i++)
				{
					$arrRow[$arrKeys[$i]] = isset($value[$arrKeys[$i]]) ? $value[$arrKeys[$i]] : null;
				}
			}
			else
			{
				$arrRow[$arrKeys[1]] = $value;
			}

			$arrNew[] = $arrRow;
		}

		return $arrNew;
	}


	/**
	 * @param array $values
	 * @param DC_General $dc
	 * @return array
	 * @throws \RuntimeException
	 */
	public function saveAssociativeFromMcw($values, DC_General $dc)
	{
		$arrNew = array();
		$arrKeys = array_keys($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['columnFields']);

		// support sub attributes of an array
		if(strpos($dc->field, '.') !== false)
		{
			$parts  = explode('.', $dc->field);
			$target =& $GLOBALS[$dc->getDataProvider()->getRoot()][$dc->getId()];

			$postKey = str_replace('.', '_', $dc->field) . '_' . $dc->getWidgetID();

			// @todo do we have to take care of html attributes here?
			$values  = \Input::post($postKey);

			foreach((array) $values as $row )
			{
				$arrNew[$row[$arrKeys[0]]] = $row[$arrKeys[1]];
			}

			foreach($parts as $part)
			{
				$new =& $target;
				unset($target);
				$target =& $new[$part];
				unset($new);
			}

			$target = $arrNew;

			$dc->getEnvironment()->getCurrentModel()->setProperty($parts[0], $GLOBALS[$dc->getDataProvider()->getRoot()][$dc->getId()][$parts[0]]);
			$dc->getEnvironment()->getCurrentModel()->setMeta(DCGE::MODEL_IS_CHANGED, true);
			$dc->getEnvironment()->getCurrentModel()->setProperty($dc->field, null);
			return;
		}

		$arrConfig = $dc->getDCA();
		$length = count($arrKeys);

		foreach((array) $values as $value )
		{
			$arrCombined = array();

			if($arrConfig['fields'][$dc->field]['eval']['multiColumns'])
			{
				for($i=1; $i<$length; $i++)
				{
					if($arrConfig['fields'][$dc->field]['eval']['columnFields'][$arrKeys[$i]]['inputType'] == 'checkbox')
					{
						$arrCombined[$arrKeys[$i]] = (bool) $value[$arrKeys[$i]];
					}

					else {
						$arrCombined[$arrKeys[$i]] = $value[$arrKeys[$i]];
					}

				}

				$arrNew[$value[$arrKeys[0]]] = $arrCombined;
			}
			else
			{
				$arrNew[$value[$arrKeys[0]]] = ($arrConfig['fields'][$dc->field]['inputType'] == 'checkbox' ? (bool) $value[$arrKeys[$i]] : $value[$arrKeys[$i]]);
			}
		}

		return $arrNew;
	}

	public function loadSubPath($value, DC_General $dc)
	{
		$config = $dc->getFieldDefinition($dc->field);

		$root  = $dc->getDataProvider()->getRoot();
		$value = $GLOBALS[$root][$dc->getId()];

		foreach($config['subPath'] as $path)
		{
			$value = $value[$path];
		}

		return $value[$dc->field];
	}

	public function saveToSubSection($value, DC_General $dc)
	{
		$config = $dc->getFieldDefinition($dc->field);

		$root = $dc->getDataProvider()->getRoot();
		$point =& $GLOBALS[$root][$dc->getId()];

		foreach($config['subPath'] as $path)
		{
			$target =& $point[$path];
			unset($point);
			$point =& $target;
			unset($target);
		}

		$point[$dc->field] = $value;

		$dc->getEnvironment()->getCurrentModel()->setProperty($config['subPath'][0], $GLOBALS[$root][$dc->getId()][$config['subPath'][0]]);
		$dc->getEnvironment()->getCurrentModel()->setMeta(DCGE::MODEL_IS_CHANGED, true);
		$dc->getEnvironment()->getCurrentModel()->setProperty($dc->field, null);

		return;
	}

}