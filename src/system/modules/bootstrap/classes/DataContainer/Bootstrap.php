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

		foreach((array) $values as $value )
		{
			$key = array_shift($value);
			$arrNew[$key] = $value;
		}

		return $arrNew;
	}

}