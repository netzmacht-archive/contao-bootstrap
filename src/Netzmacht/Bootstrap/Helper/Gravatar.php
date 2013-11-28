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