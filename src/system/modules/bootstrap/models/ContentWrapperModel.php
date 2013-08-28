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

namespace Netzmacht\Bootstrap;


/**
 * Class ContentWrapperModel extends model for wrapper element specific methods
 * @package Netzmacht\Bootstrap
 */
class ContentWrapperModel extends \ContentModel
{

	/**
	 * start type
	 *
	 * @var string
	 */
	const TYPE_START = 'start';

	/**
	 * separator type
	 *
	 * @var string
	 */
	const TYPE_SEPARATOR = 'separator';

	/**
	 * stop type
	 *
	 * @var string
	 */
	const TYPE_STOP = 'stop';


	/**
	 * group name
	 *
	 * @var string
	 */
	protected $strGroup;

	/**
	 * type
	 *
	 * @var string
	 */
	protected $strType;


	/**
	 * @param array $arrOptions
	 * @return \Model|\Model\Collection|null|void
	 */
	public static function find(array $arrOptions)
	{
		$return = parent::find($arrOptions);

		if($return instanceof \Model && !$return instanceof \ContentWrapperModel)
		{
			$row = $return->row();

			$return = new ContentWrapperModel();
			$return->setRow($row);
		}

		return $return;
	}


	/**
	 * count related elements optionally limited by type
	 *
	 * @return int
	 */
	public function countRelatedElements($type=null)
	{
		if($this->getType() == static::TYPE_START)
		{
			if($type === null)
			{
				$strColumn = 'bootstrap_parentId';
				$mixedValue = $this->bootstrap_parentId;
			}
			else
			{
				$strColumn = 'bootstrap_parentId=? AND type';
				$mixedValue = array($this->bootstrap_parentId, $this->getTypeName($type));
			}
		}
		elseif($type === null)
		{
			$strColumn = 'id !=? AND (bootstrap_parentId=? OR id=?) AND 1';
			$mixedValue = array($this->id, $this->bootstrap_parentId, $this->bootstrap_parentId, 1);
		}
		elseif($type == static::TYPE_START)
		{
			$strColumn = 'id';
			$mixedValue = $this->bootstrap_parentId;
		}
		else
		{
			$strColumn = 'id !=? AND bootstrap_parentId=? AND type';
			$mixedValue = array($this->id, $this->bootstrap_parentId, $this->getTypeName($type));

		}

		return static::countBy($strColumn, $mixedValue);
	}

	/**
	 * get related elements
	 *
	 * @param mixed $type option limit by type
	 * @return \Model|\Model\Collection|null
	 */
	public function findRelatedElements($type=null)
	{
		if($this->bootstrap_parentId == '' && $this->getType() != static::TYPE_START) {
			return null;
		}

		if($type === null)
		{
			$type = $this->getType();
		}

		$parentId = $this->getType() == static::TYPE_START ? $this->id : $this->bootstrap_parentId;

		if($type == static::TYPE_START)
		{
			if($type === null)
			{
				return static::findBy('bootstrap_parentId', $this->id, array('order' => 'sorting'));
			}
			else
			{
				return static::find(array
				(
					'column' => 'bootstrap_parentId=? AND type',
					'value'  => array($this->id, $this->getTypeName($type)),
					'order'  => 'sorting'
				));
			}
		}
		elseif($type === null)
		{
			return static::find(array
			(
				'column' => 'id != ? AND (bootstrap_parentId=? OR id=?) AND 1',
				'value'  => array($this->id, $parentId, $this->bootstrap_parentId, 1),
				'order'  => 'sorting'
			));
		}
		elseif($type == static::TYPE_START)
		{
			return static::findByPk($this->bootstrap_parentId);
		}
		else
		{
			return static::find(array
			(
				'column' => 'id != ? AND bootstrap_parentId=? AND type',
				'value'  => array($this->id, $parentId, $this->getTypeName($type)),
				'order'  => 'sorting'
			));
		}
	}


	/**
	 * try to find previous element of same type or specified type
	 *
	 * @param null $type
	 *
	 * @return \Model|\Model\Collection|null|void
	 */
	public function findPreviousElement($type=null)
	{
		if($type === null)
		{
			$type = static::getType();
		}

		return static::find(array(
			'return' => 'Model',
			'column' => 'pid=? AND ptable=? AND type=? AND sorting <',
			'value'  => array($this->pid, $this->ptable, static::getTypeName($type), $this->sorting)
		));
	}

	/**
	 * get type of element
	 *
	 * @return int
	 * @throws \Exception
	 */
	public function getType()
	{
		if($this->strType !== null || $this->initialize())
		{
			return $this->strType;
		}

		throw new \Exception('Could not detect wrapper type of Content Element');
	}


	/**
	 * get group of element
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getGroup()
	{
		if($this->strGroup !== null || $this->initialize())
		{
			return $this->strGroup;
		}

		throw new \Exception('Could not detect wrapper group of Content Element');
	}


	/**
	 * get type name
	 *
	 * @param null $type
	 * @return mixed
	 */
	public function getTypeName($type = null)
	{
		$type = $type === null ? $this->getType() : $type;

		return $GLOBALS['BOOTSTRAP']['wrappers'][$this->getGroup()][$type]['name'];
	}


	/**
	 * initialize element
	 *
	 * @return bool
	 */
	protected function initialize()
	{
		foreach($GLOBALS['BOOTSTRAP']['wrappers'] as $groupName => $group)
		{
			foreach($group as $type => $config)
			{
				if($config['name'] == $this->type)
				{
					$this->strGroup = $groupName;
					$this->strType = $type;
					return true;
				}
			}
		}

		return false;
	}

}