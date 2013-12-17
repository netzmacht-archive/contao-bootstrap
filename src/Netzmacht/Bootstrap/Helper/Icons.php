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

namespace Netzmacht\Bootstrap\Helper;

/**
 * Class Icons provides helper methos for icon handling using bootstrap
 * @package Netzmacht\Bootstrap
 */
class Icons
{

	/**
	 * cache flat icons array
	 *
	 * @var array
	 */
	protected static $flatIcons;


	/**
	 * generates code for an icon
	 *
	 * @param string $icon
	 * @param string|null $class extra css class
	 *
	 * @return string
	 */
	public static function generateIcon($icon, $class=null)
	{
		$key = $GLOBALS['BOOTSTRAP']['icons']['active'];

		return sprintf(
			$GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['template'],
			$icon . ($class == null ? '' : ' ' . $class)
		);
	}


	/**
	 * get all icons of a group, as grouped array or as flat array
	 *
	 * @param mixed $group string for an icon group, true if a flat array
	 *
	 * @return array [group => array]
	 */
	public static function getIcons($group=null)
	{
		$key = $GLOBALS['BOOTSTRAP']['icons']['active'];

		// load icons if not done so far
		if(!isset($GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['icons']))
		{
			$GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['icons'] =
				include TL_ROOT . '/' . $GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['path'];
		}

		// get all icons
		if($group === null)
		{
			return $GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['icons'];
		}

		// get all icons as flat array
		elseif($group === true)
		{
			if(self::$flatIcons === null) {
				$icons = array();

				foreach ($GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['icons'] as $groupIcons)
				{
					$icons = array_merge($icons, $groupIcons);
				}

				self::$flatIcons = $icons;
			}

			return self::$flatIcons;
		}

		return $GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['icons'];
	}


	/**
	 * get icon template
	 *
	 * @return string
	 */
	public static function getIconTemplate()
	{
		$key = $GLOBALS['BOOTSTRAP']['icons']['active'];
		return $GLOBALS['BOOTSTRAP']['icons']['sets'][$key]['template'];
	}


	/**
	 * check if an icon exists
	 *
	 * @param string $icon
	 * @return bool
	 */
	public static function iconExists($icon)
	{
		$icons = self::getIcons(true);

		return in_array($icon, $icons);
	}

}