<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 18.09.13
 * Time: 09:46
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap\DcGeneral\Data;

use DcGeneral\Data\CollectionInterface;
use DcGeneral\Data\ConfigInterface;
use DcGeneral\Data\DefaultCollection;
use DcGeneral\Data\DefaultConfig;
use DcGeneral\Data\DefaultModel;
use DcGeneral\Data\DriverInterface;
use DcGeneral\Data\ModelInterface;

class BootstrapDriver implements DriverInterface
{
	protected $strSource = null;


	/**
	 * Set base config with source and other necessary parameter.
	 *
	 * @param array $arrConfig The configuration to use.
	 *
	 * @return void
	 *
	 * @throws \RuntimeException when no source has been defined.
	 */
	public function setBaseConfig(array $arrConfig)
	{
		if(!isset($arrConfig['source']))
		{
			throw new \RuntimeException('Missing directory name');
		}
		elseif(!is_dir(TL_ROOT . '/' . $arrConfig['source']))
		{
			if(!$arrConfig['createSource'])
			{
				throw new \RuntimeException('Directory does not exists');
			}

			$objFiles = \Files::getInstance();
			$objFiles->mkdir($arrConfig['source']);
		}

		$this->strSource = $arrConfig['source'];
	}


	/**
	 * Return an empty configuration object.
	 *
	 * @return ConfigInterface
	 */
	public function getEmptyConfig()
	{
		return DefaultConfig::init();
	}


	/**
	 * Fetch an empty single record (new model).
	 *
	 * @return ModelInterface
	 */
	public function getEmptyModel()
	{
		$objModel = new DefaultModel();
		$objModel->setProviderName($this->strSource);

		return $objModel;
	}


	/**
	 * Fetch an empty single collection (new model list).
	 *
	 * @return CollectionInterface
	 */
	public function getEmptyCollection()
	{
		return new DefaultCollection();
	}


	/**
	 * Fetch a single or first record by id or filter.
	 *
	 * If the model shall be retrieved by id, use $objConfig->setId() to populate the config with an Id.
	 *
	 * If the model shall be retrieved by filter, use $objConfig->setFilter() to populate the config with a filter.
	 *
	 * @param ConfigInterface $objConfig
	 *
	 * @return ModelInterface
	 */
	public function fetch(ConfigInterface $objConfig)
	{
		if($objConfig->getId() == null)
		{
			$objConfig->setId('layout');
		}

		if(!isset($GLOBALS['BOOTSTRAP'][$objConfig->getId()]))
		{
			return null;
		}

		$objModel = $this->getEmptyModel();
		$objModel->setID($objConfig->getId());

		if(file_exists($this->getFilePath($objConfig->getId())))
		{
			require_once $this->getFilePath($objConfig->getId());
		}

		foreach($GLOBALS['BOOTSTRAP'][$objConfig->getId()] as $key => $value)
		{
			$objModel->setProperty($key, $value);
		}

		return $objModel;
	}


	/**
	 * Fetch all records (optional filtered, sorted and limited).
	 *
	 * This returns a collection of all models matching the config object. If idOnly is true, an array containing all
	 * matching ids is returned.
	 *
	 * @param ConfigInterface $objConfig
	 *
	 * @return CollectionInterface|array
	 */
	public function fetchAll(ConfigInterface $objConfig)
	{
		$objIterator = new \DirectoryIterator(TL_ROOT . '/' . $this->strSource);

		if($objConfig->getIdOnly())
		{
			$arrIds = array();

			foreach($objIterator as $file)
			{
				if($file->isFile())
				{
					$arrIds[] = $file->getBasename();
				}
			}

			return $arrIds;
		}

		$objCollection = $this->getEmptyCollection();
		$arrIds = $objConfig->getIds();

		foreach($objIterator as $file)
		{
			$id = $file->getBasename('.php');

			if(!empty($arrIds) && !in_array($id, $arrIds))
			{
				continue;
			}

			if(!file_exists($this->getFilePath($id)))
			{
				continue;
			}

			$objModel = $this->getEmptyModel();
			$objModel->setID($id);

			require_once $this->getFilePath($id);

			if(!isset($GLOBALS['BOOTSTRAP'][$id]))
			{
				continue;
			}

			foreach($GLOBALS['BOOTSTRAP'][$id] as $key => $value)
			{
				$objModel->setProperty($key, $value);
			}

			$objCollection->add($objModel);
		}

		return $objCollection;
	}


	/**
	 * Retrieve all unique values for the given property.
	 *
	 * The result set will be an array containing all unique values contained in the data provider.
	 * Note: this only re-ensembles really used values for at least one data set.
	 *
	 * The only information being interpreted from the passed config object is the first property to fetch and the
	 * filter definition.
	 *
	 * @param ConfigInterface $objConfig   The filter config options.
	 *
	 * @return CollectionInterface
	 */
	public function getFilterOptions(ConfigInterface $objConfig)
	{
		$arrProperties = $objConfig->getFields();
		$strProperty = $arrProperties[0];

		if (count($arrProperties) <> 1)
		{
			throw new \RuntimeException('objConfig must contain exactly one property to be retrieved.');
		}
		elseif($strProperty != 'id')
		{
			throw new \RuntimeException('Only id supported as filter option');
		}

		// @todo be aware what will be effected when i change config here?
		$objConfig->setIdOnly(true);
		return $this->fetchAll($objConfig);
	}


	/**
	 * Return the amount of total items (filtering may be used in the config).
	 *
	 * @param ConfigInterface $objConfig
	 *
	 * @return int
	 */
	public function getCount(ConfigInterface $objConfig)
	{
		// @todo be aware what will be effected when i change config here?
		$objConfig->setIdOnly(true);
		$arrIds = $this->fetchAll($objConfig);

		return count($arrIds);
	}


	/**
	 * Save an item to the data provider.
	 *
	 * If the item does not have an Id yet, the save operation will add it as a new row to the database and
	 * populate the Id of the model accordingly.
	 *
	 * @param ModelInterface $objItem   The model to save back.
	 *
	 * @return ModelInterface The passed model.
	 */
	public function save(ModelInterface $objItem)
	{
		$arrSet = array();

		if($objItem->getId() == '' || $objItem->getId() == null)
		{
			throw new \RuntimeException('No id given but required');
		}

		$data = '<?php' . "\n\n";
		$data .= $this->prepareForSave($objItem);

		$objFile = new \File($this->getFilePath($objItem->getId(), false));

		var_dump($data);
		$objFile->write($data);
		$objFile->close();
	}


	/**
	 * @param $item
	 * @param array $arrTree
	 * @return string
	 */
	protected function prepareForSave($item, $arrTree = array('BOOTSTRAP'))
	{
		$buffer = '';

		foreach($item as $key => $value)
		{
			if($key == 'id' && count($arrTree) == 1)
			{
				continue;
			}

			$arrNewTree = $arrTree;
			$arrNewTree[] = $key;

			if(is_array($value))
			{

				$buffer .= $this->prepareForSave($value, $arrNewTree);
			}
			else
			{
				$buffer .= '$GLOBALS[\'' . implode('\'][\'', $arrNewTree) . '\'] ';
				$buffer .= ' = ' . $this->prepareValueForSave($value) . ";\n";
			}
		}

		return $buffer;
	}


	/**
	 * @param $value
	 * @return int|string
	 * @throws \RuntimeException
	 */
	protected function prepareValueForSave($value)
	{
		if(is_bool($value))
		{
			return $value ? 'true' : 'false';
		}
		elseif(is_numeric($value))
		{
			return $value;
		}
		elseif(is_string($value))
		{
			return '\'' . addslashes($value) . '\'';

		}
		else
		{
			throw new \RuntimeException('Invalid value given');
		}
	}


	/**
	 * Save a collection of items to the data provider.
	 *
	 * @param CollectionInterface $objItems The collection containing all items to be saved.
	 *
	 * @return void
	 */
	public function saveEach(CollectionInterface $objItems)
	{
		foreach($objItems as $value)
		{
			$this->save($value);
		}
	}


	/**
	 * Delete an item.
	 *
	 * The given value may be either integer, string or an instance of Model
	 *
	 * @param mixed $item Id or the model itself, to delete.
	 *
	 * @throws \RuntimeException when an unusable object has been passed.
	 */
	public function delete($item)
	{
		if($item instanceof ModelInterface)
		{
			$item = $item->getId();
		}

		$objFiles = \Files::getInstance();
		$objFiles->delete($this->getFilePath($item));
	}


	/**
	 * Save a new version of a model.
	 *
	 * @param ModelInterface $objModel    The model for which a new version shall be created.
	 *
	 * @param string $strUsername The username to attach to the version as creator.
	 *
	 * @return void
	 */
	public function saveVersion(ModelInterface $objModel, $strUsername)
	{
		throw new \RuntimeException('Versioning is not supported');
	}


	/**
	 * Return a model based of the version information.
	 *
	 * @param mixed $mixID      The ID of the record.
	 *
	 * @param mixed $mixVersion The ID of the version.
	 *
	 * @return ModelInterface
	 */
	public function getVersion($mixID, $mixVersion)
	{
		throw new \RuntimeException('Versioning is not supported');
	}


	/**
	 * Return a list with all versions for the model with the given Id.
	 *
	 * @param mixed $mixID         The ID of the row.
	 *
	 * @param boolean $blnOnlyActive If true, only active versions will get returned, if false all version will get
	 *                               returned.
	 *
	 * @return CollectionInterface
	 */
	public function getVersions($mixID, $blnOnlyActive = false)
	{
		return null;
	}


	/**
	 * Set a version as active.
	 *
	 * @param mixed $mixID      The ID of the model.
	 *
	 * @param mixed $mixVersion The version number to set active.
	 */
	public function setVersionActive($mixID, $mixVersion)
	{
		throw new \RuntimeException('Versioning is not supported');
	}


	/**
	 * Retrieve the current active version for a model.
	 *
	 * @param mixed $mixID The ID of the model.
	 *
	 * @return mixed The current version number of the requested row.
	 */
	public function getActiveVersion($mixID)
	{
		throw new \RuntimeException('Versioning is not supported');
	}


	/**
	 * Reset the fallback field.
	 *
	 * This clears the given property in all items in the data provider to an empty value.
	 *
	 * Documentation:
	 *      Evaluation - fallback => If true the field can only be assigned once per table.
	 *
	 * @param string $strField The field to reset.
	 *
	 * @return void
	 */
	public function resetFallback($strField)
	{
		throw new \RuntimeException('resetFallback is not supported');
	}


	/**
	 * Check if the value is unique in the data provider.
	 *
	 * @param string $strField the field in which to test.
	 *
	 * @param mixed $varNew   the value about to be saved.
	 *
	 * @param int $intId    the (optional) id of the item currently in scope - pass null for new items.
	 *
	 * Documentation:
	 *      Evaluation - unique => If true the field value cannot be saved if it exists already.
	 *
	 * @return boolean
	 */
	public function isUniqueValue($strField, $varNew, $intId = null)
	{
		throw new \RuntimeException('Unique fields are not supported');
	}


	/**
	 * Check if a property with the given name exists in the data provider.
	 *
	 * @param string $strField The name of the property to search.
	 *
	 * @return boolean
	 */
	public function fieldExists($strField)
	{
		// @todo We acutally need an ID here to check if field exists.
		return true;
	}


	/**
	 * Check if two models have the same values in all properties.
	 *
	 * @param ModelInterface $objModel1 The first model to compare.
	 *
	 * @param ModelInterface $objModel2 The second model to compare.
	 *
	 * @return boolean True - If both models are same, false if not.
	 */
	public function sameModels($objModel1, $objModel2)
	{
		foreach ($objModel1 as $key => $value)
		{
			if ($key == "id")
			{
				continue;
			}

			if (is_array($value))
			{
				if (!is_array($objModel2->getProperty($key)))
				{
					return false;
				}

				if (serialize($value) != serialize($objModel2->getProperty($key)))
				{
					return false;
				}
			}
			else if ($value != $objModel2->getProperty($key))
			{
				return false;
			}
		}

		return true;
	}


	/**
	 * get file path of given id
	 *
	 * @param $strId
	 * @return string
	 */
	protected function getFilePath($strId, $blnIncludeRoot = true)
	{
		$base = $blnIncludeRoot ? (TL_ROOT . '/') : '';

		return $base . $this->strSource . '/' . $strId . '.php';
	}

}