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
	 * @var bool
	 */
	protected static $initialized;


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
		static::initialize();

		return sprintf(
			$GLOBALS['BOOTSTRAP']['icons']['template'],
			$icon . ($class != null ?: ' ' . $class)
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
		static::initialize();

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
	 * get icon template
	 *
	 * @return string
	 */
	public static function getIconTemplate()
	{
		static::initialize();

		return $GLOBALS['BOOTSTRAP']['icons']['template'];
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


	/**
	 * initialize icon configuration
	 */
	public static function initialize()
	{
		if(static::$initialized)
		{
			return;
		}

		$set = $GLOBALS['TL_CONFIG']['bootstrapIconSet'];

		$GLOBALS['BOOTSTRAP']['icons']['set'] = include(TL_ROOT . '/' . $GLOBALS['BOOTSTRAP']['icons']['sets'][$set]['path']);
		$GLOBALS['BOOTSTRAP']['icons']['template'] = $GLOBALS['BOOTSTRAP']['icons']['sets'][$set]['template'];

		static::$initialized = true;
	}

}