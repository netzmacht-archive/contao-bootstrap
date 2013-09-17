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

use Netzmacht\Bootstrap\Helper\Icons;

/**
 * Class InsertTags provides insert tags of the Bootstrap extension
 * @package Netzmacht\Bootstrap
 */
class InsertTags extends \Controller
{

	/**
	 * replace tags for the hook, delegates to each supported tag
	 *
	 * @param      $tag
	 * @param bool $blnCache
	 *
	 * @return bool
	 */
	public function replaceTags($tag, $blnCache=true)
	{
		$parts = explode('::', $tag);

		if(method_exists($this, $parts[0]))
		{
			$method = $parts[0];
			array_shift($parts);

			return $this->$method($parts, $blnCache);
		}

		return false;
	}


	/**
	 * Replace modal tag, modal tag supports following formats:
	 *
	 * modal::id
	 *      - SimpleAjax.php?modal=id?page=Pageid
	 * modal::link::id
	 *      - <a href="#modal-id" data-toggle="modal">Module name</a>
	 * modal::url::id
	 *      - #modal-id
	 * modal::link::id::title
	 *      - <a href="#modal-id" data-toggle="modal">Title</a>
	 *
	 * modal::id::type::typeid
	 *      - SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid
	 * modal::link::id::type::typeid
	 *      - <a href="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid" data-toggle="modal" data-remote="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid">Module name</a>
	 *      - The data-target is nessecary because Bootstrap ony checks for data-remote if content is cached
	 *      - href attribute is set for accessibility issues
	 * modal::link::id::type::typeid::title
	 *      - <a href="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid" data-toggle="modal" data-remote="SimpleAjax.php?modal=id?page=Pageid&dynamic=type&id=typeid">Title</a>
	 *
	 * modal::url::
	 *
	 * @param      $parts
	 * @param bool $blnCache
	 * @return bool|string
	 */
	protected function modal($parts, $blnCache)
	{
		if(is_numeric($parts[0]))
		{
			array_insert($parts, 0, array('remote'));
		}

		if(!isset($GLOBALS['TL_BODY']['bootstrap-modal-' . $parts[1]]))
		{
			$model = \ModuleModel::findByPk($parts[1]);

			if($model != null && $model->type == 'bootstrap_modal')
			{
				$this->getFrontendModule($parts[1]);
			}
		}

		$count = count($parts);

		if($count == 2 || $count == 3)
		{
			switch($parts[0])
			{
				case 'remote':
					$buffer = sprintf($GLOBALS['BOOTSTRAP']['modal']['remoteUrl'], $GLOBALS['objPage']->id, $parts[1]);
					break;

				case 'url':
				case 'link':
					$model = \ModuleModel::findByPk($parts[1]);

					if($model === null || $model->type != 'bootstrap_modal')
					{
						return false;
					}

					$cssId = deserialize($model->cssID, true);
					$buffer = '#' . ($cssId[0] != '' ? $cssId[0] : 'modal-' . $model->id);

					if($parts[0] != 'link')
					{
						break;
					}

					$parts[2] = ($count == 3) ? $parts[2] : $model->name;

					$buffer = sprintf('<a href="%s" data-toggle="modal">%s</a>', $buffer, $parts[2]);
					break;

				default:
					return false;
			}

			return $buffer;
		}
		elseif($count == 4 || $count == 5)
		{
			switch($parts[0])
			{
				case 'url':
				case 'link':
				case 'remote':
					$parts[0] = $GLOBALS['objPage']->id;
					$buffer = vsprintf($GLOBALS['BOOTSTRAP']['modal']['remoteDynamicUrl'], $parts);

					if($parts[0] != 'link')
					{
						break;
					}

					if($count == 4)
					{
						$model = \ModuleModel::findByPk($parts[1]);

						if($model === null || $model->type != 'bootstrap_modal')
						{
							return false;
						}

						$parts[6] = $model->name;

						$cssId = deserialize($model->cssID, true);
						$cssId = '#' . ($cssId[0] != '' ? $cssId[0] : 'modal-' . $model->id);

						$buffer = sprintf( '<a href="%s" data-toggle="modal" data-remote="%s">%s</a>', $cssId, $buffer, $parts[6]);
					}

					break;

				default:
					return false;
			}

			return $buffer;
		}


		return false;
	}


	/**
	 * generate an icon using insert tag
	 *
	 * icon::example
	 * icon::exmaple::extra-css-class
	 *
	 * @param $tag
	 *
	 * @return bool|string
	 */
	protected function icon($parts, $cache)
	{
		return Icons::generateIcon($parts[0], isset($parts[1]) ? $parts[1] : null);
	}


	/**
	 * alias for InsertTags::icon
	 *
	 * icon::example
	 * icon::exmaple::extra-css-class
	 *
	 * @param $tag
	 *
	 * @return bool|string
	 */
	protected function i($parts, $cache)
	{
		return $this->icon($parts, $cache);
	}

}