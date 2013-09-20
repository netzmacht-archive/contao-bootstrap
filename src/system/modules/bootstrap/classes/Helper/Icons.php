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
		return sprintf(
			$GLOBALS['BOOTSTRAP']['miscellaneous']['icons']['template'],
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
		// get all icons
		if($group === null) {
			return $GLOBALS['BOOTSTRAP']['miscellaneous']['icons']['set'];
		}

		// get all icons as flat array
		elseif($group === true) {
			if(self::$flatIcons === null) {
				$icons = array();

				foreach ($GLOBALS['BOOTSTRAP']['miscellaneous']['icons']['set'] as $groupIcons) {
					$icons = array_merge($icons, $groupIcons);
				}

				self::$flatIcons = $icons;
			}

			return self::$flatIcons;
		}

		//
		if(isset($GLOBALS['BOOTSTRAP']['miscellaneous']['icons']['set'][$group])) {
			return $GLOBALS['BOOTSTRAP']['miscellaneous']['icons']['set'][$group];
		}

		return array();
	}


	/**
	 * get icon template
	 *
	 * @return string
	 */
	public static function getIconTemplate()
	{
		return $GLOBALS['BOOTSTRAP']['miscellaneous']['icons']['template'];
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