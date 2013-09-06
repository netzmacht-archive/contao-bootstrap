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
 * Class GeneralDataContainer provides useful callbacks for different tables
 *
 * @package Netzmacht\Bootstrap
 */
class GeneralDataContainer extends \Backend
{

	/**
	 * Get all modules prepared for select wizard
	 *
	 * @return array
	 */
	public function getAllModules()
	{
		$arrModules = array();

		$objModules = $this->Database
			->execute("SELECT m.id, m.name, t.name AS theme FROM tl_module m LEFT JOIN tl_theme t ON m.pid=t.id ORDER BY t.name, m.name");

		while ($objModules->next())
		{
			$arrModules[$objModules->theme][$objModules->id] = $objModules->name . ' (ID ' . $objModules->id . ')';
		}

		return $arrModules;
	}


	/**
	 * get all templates. A templatePrefix can be defined using eval.templatePrefix
	 *
	 * @param $dc
	 *
	 * @return array
	 */
	public function getTemplates($dc)
	{
		if(isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix']))
		{
			return $this->getTemplateGroup($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix']);
		}

		return array_keys(\TemplateLoader::getFiles());
	}


	/**
	 * @param DataContainer $dc
	 *
	 * @return string
	 */
	public function pagePicker(\DataContainer $dc)
	{
		return sprintf(' <a href="contao/page.php?do=%s&amp;table=%s&amp;field=%s&amp;value=%s" title="%s" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'%s\',\'url\':this.href,\'id\':\'%s\',\'tag\':\'ctrl_%s\',\'self\':this});return false">%s</a>',
			\Input::get('do'),
			$dc->table,
			$dc->field,
			str_replace(array('{{link_url::', '}}'), '', $dc->value),
			specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']),
			specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])),
			$dc->field,
			$dc->field . ((\Input::get('act') == 'editAll') ? '_' . $dc->id : ''),
			$this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"')
		);
	}

}