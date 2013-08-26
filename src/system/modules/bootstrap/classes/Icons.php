<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 22.08.13
 * Time: 09:34
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;

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
			'<%s class="%s%s%s"></%s>',
			$GLOBALS['BOOTSTRAP']['icons']['tag'],
			$GLOBALS['BOOTSTRAP']['icons']['classPrefix'],
			$icon,
			$class == null ? '' : ' ' . $class,
			$GLOBALS['BOOTSTRAP']['icons']['tag']
		);
	}


	/**
	 * get all icons of a group, as grouped array or as flat array
	 *
	 * @param mixed $group string for an icon group, true if
	 *
	 * @return array [group => array]
	 */
	public static function getIcons($group=null)
	{
		// get all icons
		if($group === null) {
			return $GLOBALS['BOOTSTRAP']['icons']['set'];
		}

		// get all icons as flat array
		elseif($group === true) {
			if(self::$flatIcons === null) {
				$icons = array();

				foreach ($GLOBALS['BOOTSTRAP']['icons']['set'] as $groupIcons) {
					$icons = array_merge($icons, $groupIcons);
				}

				self::$flatIcons = $icons;
			}

			return self::$flatIcons;
		}

		//
		if(isset($GLOBALS['BOOTSTRAP']['icons']['set'][$group])) {
			return $GLOBALS['BOOTSTRAP']['icons']['set'][$group];
		}

		return array();
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