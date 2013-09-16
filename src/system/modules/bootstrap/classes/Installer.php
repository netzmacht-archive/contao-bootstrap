<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 26.08.13
 * Time: 08:36
 * To change this template use File | Settings | File Templates.
 */

namespace Netzmacht\Bootstrap;


/**
 * Class Installer
 * @package Netzmacht\Bootstrap
 */
class Installer extends \Backend
{

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		$this->import('Database');

		parent::__construct();

		$this->User->authenticate();

		$this->loadLanguageFile('default');
		$this->loadLanguageFile('modules');
	}


	/**
	 * method for runonce.php
	 */
	public function runOnce()
	{
		if($this->User->isAdmin)
		{
			$this->setupSections();
			$this->installDependencies();
		}
	}


	/**
	 * install all dependencies of bootstrap
	 */
	protected function installDependencies()
	{
		require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap/installer.php';

		$GLOBALS['TL_CONFIG']['bootstrapInstalledDependencies'] = deserialize($GLOBALS['TL_CONFIG']['bootstrapInstalledDependencies'], true);

		$files = \Files::getInstance();

		foreach($GLOBALS['BOOSTRAP']['installer'] as $dependencyName => $dependency)
		{
			// already installed
			if(in_array($dependencyName, $GLOBALS['TL_CONFIG']['bootstrapInstalledDependencies']))
			{
				continue;
			}

			// condition failed
			if(isset($dependency['condition']) && !call_user_func($dependency['condition']))
			{
				continue;
			}

			// remove existing files
			if(isset($dependency['clearTarget']) && $dependency['clearTarget'] && is_dir(TL_ROOT . '/' . $dependency['target']))
			{
				$files->rrdir($dependency['target']);
			}

			$content = file_get_contents($dependency['file']);

			$tempName = tempnam(TL_ROOT . '/system/tmp', 'bootstrap_');

			$tempFile = fopen($tempName, 'w+');
			fwrite($tempFile, $content);
			fclose($tempFile);

			$zip = new \ZipReader(str_replace(TL_ROOT, '', $tempName));

			while($zip->next())
			{
				// does not match root
				if($dependency['root'] != '' && strpos($zip->file_name, $dependency['root']) !== 0)
				{
					continue;
				}

				$fileName = str_replace($dependency['root'], '', $zip->file_name);

				// not in the included paths
				if(isset($dependency['paths']) && !$this->fileMatchPaths($fileName, $dependency['paths']))
				{
					continue;
				}

				$file = new \File($dependency['target'] . $fileName);
				$file->write($zip->unzip());
				$file->close();
			}



			$GLOBALS['TL_CONFIG']['bootstrapInstalledDependencies'][] = $dependencyName;

			$this->log(
				sprintf('Bootstrap dependency "%s" installed', $dependencyName),
				'Netzmacht\Bootstrap\Installer::installDependencies',
				TL_INFO
			);
		}

		$files->delete($tempName);

		$config = \Config::getInstance();
		$config->add('$GLOBALS[\'TL_CONFIG\'][\'bootstrapInstalledDependencies\']', serialize($GLOBALS['TL_CONFIG']['bootstrapInstalledDependencies']));
		$config->save();
	}


	/**
	 * setup required sections
	 */
	protected function setupSections()
	{
		if($GLOBALS['TL_CONFIG']['customSections'] == '') {
			$GLOBALS['TL_CONFIG']['customSections'] = 'bootstrap';
		}
		elseif(strpos($GLOBALS['TL_CONFIG']['customSections'], 'bootstrap') === false) {
			$GLOBALS['TL_CONFIG']['customSections'] .= ',bootstrap';
		}

		$config = \Config::getInstance();
		$config->add('$GLOBALS[\'TL_CONFIG\'][\'customSections\']', $GLOBALS['TL_CONFIG']['customSections']);
		$config->save();
	}


	/**
	 * check if file is in one of the defined paths
	 * @param $fileName
	 * @param $paths
	 *
	 * @return bool
	 */
	protected function fileMatchPaths($fileName, $paths)
	{
		foreach($paths as $path)
		{
			if(strpos($fileName, $path) === 0)
			{
				return true;
			}
		}

		return false;
	}
}