<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 29.08.13
 * Time: 08:23
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


/**
 * Class Gravatar store basic gravatar methos for getting an gravatar
 * @package Netzmacht\Bootstrap
 */
class Gravatar
{

	/**
	 * @var string
	 */
	protected static $baseHref = 'http://www.gravatar.com/avatar/';


	/**
	 * generate gravatar url
	 * @param $email
	 * @param null $size
	 * @param null $default
	 * @return string
	 */
	public static function generateUrl($email, $size=null, $default=null)
	{
		if($size == null && isset($GLOBALS['TL_CONFIG']['gravatarSize']))
		{
			$size = $GLOBALS['TL_CONFIG']['gravatarSize'];
		}

		if($default == null)
		{
			if(isset($GLOBALS['TL_CONFIG']['gravatarDefault']))
			{
				$default = $GLOBALS['TL_CONFIG']['gravatarDefault'];
			}
		}

		$separator = '?';
		$link = static::$baseHref . md5(strtolower(trim($email)));

		if($size)
		{
			$link .= $separator . 's=' . $size;
			$separator = '&';
		}

		if($default)
		{
			$link .= $separator . 'd=' . urlencode($default);
		}

		return $link;
	}

	/**
	 * @todo add generateProfileUrl
	 */

}