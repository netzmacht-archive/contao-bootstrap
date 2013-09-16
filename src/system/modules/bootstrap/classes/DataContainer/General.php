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

namespace Netzmacht\Bootstrap\DataContainer;

/**
 * Class GeneralDataContainer provides useful callbacks for different tables
 *
 * @package Netzmacht\Bootstrap
 */
class General extends \Backend
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
	 * creates an meta palette of an palettes
	 *
	 * @param string $name
	 * @return array
	 */
	protected function getMetaPaletteOfPalette($table, $name='default', $type='palettes')
	{
		$palette     = $GLOBALS['TL_DCA'][$table][$type][$name];
		$metaPalette = array();
		$legends     = explode(';', $palette);

		foreach($legends as $legend)
		{
			$fields = explode(',', $legend);

			preg_match('/\{(.*)_legend(:hide)?\}/', $fields[0], $matches);

			if(isset($matches[2]))
			{
				$fields[0] = $matches[2];
			}
			else
			{
				array_shift($fields);
			}

			$metaPalette[$matches[1]] = $fields;
		}

		return $metaPalette;
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
		$prefix = '';

		if(isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix']))
		{
			$prefix = $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templatePrefix'];
		}

		$key = null;

		if(isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templateThemeId']))
		{
			$key = $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['templateThemeId'];
		}

		$key = $key == '' ? null : $dc->activeRecord->$key;

		return $this->getTemplateGroup($prefix, $key);
	}


	/**
	 * @param \DataContainer $dc
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


	public static function getTemplateGroup($strPrefix, $intThemeId=null)
	{
		$arrTemplates = array();

		// Get the default templates
		foreach (\TemplateLoader::getPrefixedFiles($strPrefix) as $strTemplate)
		{
			$arrTemplates[$strTemplate] = $strTemplate;
		}

		$arrCustomized = glob(TL_ROOT . '/templates/' . $strPrefix . '*');

		// Add the customized templates
		if (is_array($arrCustomized))
		{
			foreach ($arrCustomized as $strFile)
			{
				$strTemplate = basename($strFile, strrchr($strFile, '.'));

				if (!isset($arrTemplates[$strTemplate]))
				{
					$arrTemplates[$strTemplate] = $strTemplate;
				}
			}
		}

		// Do not look for back end templates in theme folders (see #5379)
		if ($strPrefix == 'be_' || $strPrefix == 'mail_')
		{
			return $arrTemplates;
		}

		$arrDefault = $arrTemplates;
		$arrTemplates = array
		(
		    'safeTpl' => $arrDefault,
		    'unsafeTpl' => array(),
		);

		// Try to select the themes (see #5210)
		try
		{
			$objTheme = \ThemeModel::findAll(array('order'=>'name'));
		}
		catch (\Exception $e)
		{
			$objTheme = null;
		}

		// Add the theme templates
		if ($objTheme === null)
		{
			return $arrTemplates;
		}

		while ($objTheme->next())
		{
			$strGroup = ($objTheme->id == $intThemeId) ? 'safeTpl' : 'unsafeTpl';

			if ($objTheme->templates == '')
			{
				continue;
			}

			$arrThemeTemplates = glob(TL_ROOT . '/' . $objTheme->templates . '/' . $strPrefix . '*');

			if (!is_array($arrThemeTemplates))
			{
				continue;
			}

			foreach ($arrThemeTemplates as $strFile)
			{
				$strTemplate = basename($strFile, strrchr($strFile, '.'));

				if (!isset($arrTemplates[$strGroup][$strTemplate]))
				{
					$arrTemplates[$strGroup][$strTemplate] = $strTemplate . ' (' . sprintf($GLOBALS['TL_LANG']['MSC']['templatesTheme'], $objTheme->name) . ')';
				}
				else
				{
					$arrTemplates[$strGroup][$strTemplate] .= ' (' . sprintf($GLOBALS['TL_LANG']['MSC']['templatesTheme'], $objTheme->name) . ')';
				}
			}
		}

		return $arrTemplates;

	}

}