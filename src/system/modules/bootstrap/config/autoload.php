<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Bootstrap
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Netzmacht',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Forms
	'Netzmacht\Bootstrap\BootstrapWidget'               => 'system/modules/bootstrap/forms/BootstrapWidget.php',
	'Netzmacht\Bootstrap\FormButton'                    => 'system/modules/bootstrap/forms/FormButton.php',

	// Modules
	'Netzmacht\Bootstrap\ModuleModal'                   => 'system/modules/bootstrap/modules/ModuleModal.php',
	'Netzmacht\Bootstrap\BootstrapModule'               => 'system/modules/bootstrap/modules/BootstrapModule.php',
	'Netzmacht\Bootstrap\ModuleNavbar'                  => 'system/modules/bootstrap/modules/ModuleNavbar.php',

	// Elements
	'Netzmacht\Bootstrap\ContentButton'                 => 'system/modules/bootstrap/elements/ContentButton.php',
	'Netzmacht\Bootstrap\ContentAccordionGroup'         => 'system/modules/bootstrap/elements/ContentAccordionGroup.php',
	'Netzmacht\Bootstrap\ContentButtons'                => 'system/modules/bootstrap/elements/ContentButtons.php',
	'Netzmacht\Bootstrap\ContentCarousel'               => 'system/modules/bootstrap/elements/ContentCarousel.php',
	'Netzmacht\Bootstrap\BootstrapWrapperElement'       => 'system/modules/bootstrap/elements/BootstrapWrapperElement.php',
	'Netzmacht\Bootstrap\ContentCollapse'               => 'system/modules/bootstrap/elements/ContentCollapse.php',
	'Netzmacht\Bootstrap\BootstrapContentElement'       => 'system/modules/bootstrap/elements/BootstrapContentElement.php',
	'Netzmacht\Bootstrap\ContentColumnSet'              => 'system/modules/bootstrap/elements/ContentColumnSet.php',
	'Netzmacht\Bootstrap\ContentTab'                    => 'system/modules/bootstrap/elements/ContentTab.php',

	// Classes
	'Netzmacht\Bootstrap\Gravatar'                      => 'system/modules/bootstrap/classes/Gravatar.php',
	'Netzmacht\Bootstrap\Icons'                         => 'system/modules/bootstrap/classes/Icons.php',
	'Netzmacht\Bootstrap\Attributes'                    => 'system/modules/bootstrap/classes/Attributes.php',
	'Netzmacht\Bootstrap\TemplateModifier'              => 'system/modules/bootstrap/classes/TemplateModifier.php',
	'Netzmacht\Bootstrap\Installer'                     => 'system/modules/bootstrap/classes/Installer.php',

	// Widgets
	'Netzmacht\Bootstrap\Buttons'                       => 'system/modules/bootstrap/widgets/Buttons.php',

	// DataContainer
	'Netzmacht\Bootstrap\DataContainer\WrapperElements' => 'system/modules/bootstrap/dataContainer/WrapperElements.php',
	'Netzmacht\Bootstrap\DataContainer\Content'         => 'system/modules/bootstrap/dataContainer/Content.php',
	'Netzmacht\Bootstrap\DataContainer\Bootstrap'       => 'system/modules/bootstrap/dataContainer/Bootstrap.php',

	// Models
	'Netzmacht\Bootstrap\ContentWrapperCollection'      => 'system/modules/bootstrap/models/ContentWrapperCollection.php',
	'Netzmacht\Bootstrap\ContentWrapperModel'           => 'system/modules/bootstrap/models/ContentWrapperModel.php',
	'Contao\BootstrapContentModel'                      => 'system/modules/bootstrap/models/BootstrapContentModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'gallery_grid'              => 'system/modules/bootstrap/templates',
	'ce_bootstrap_columnset'    => 'system/modules/bootstrap/templates',
	'mod_navbar_container'      => 'system/modules/bootstrap/templates',
	'ce_bootstrap_buttons_item' => 'system/modules/bootstrap/templates',
	'ce_bootstrap_tab'          => 'system/modules/bootstrap/templates',
	'bootstrap_buttons'         => 'system/modules/bootstrap/templates',
	'search_default'            => 'system/modules/bootstrap/templates',
	'ce_bootstrap_carousel'     => 'system/modules/bootstrap/templates',
	'mod_navbar'                => 'system/modules/bootstrap/templates',
	'mod_boostrap_modal'        => 'system/modules/bootstrap/templates',
	'form_checkbox_generate'    => 'system/modules/bootstrap/templates',
	'form_radio_generate'       => 'system/modules/bootstrap/templates',
	'navbar_brand'              => 'system/modules/bootstrap/templates',
	'navbar'                    => 'system/modules/bootstrap/templates',
	'gallery_carousel'          => 'system/modules/bootstrap/templates',
	'com_bootstrap'             => 'system/modules/bootstrap/templates',
	'ce_bootstrap_button'       => 'system/modules/bootstrap/templates',
	'ce_bootstrap_buttons'      => 'system/modules/bootstrap/templates',
	'navbar_toggle'             => 'system/modules/bootstrap/templates',
	'ce_accordion_group'        => 'system/modules/bootstrap/templates',
	'mod_bootstrap_modal'       => 'system/modules/bootstrap/templates',
	'form_modal'                => 'system/modules/bootstrap/templates',
	'nav_bootstrap_dropdown'    => 'system/modules/bootstrap/templates',
	'bootstrap_buttons_item'    => 'system/modules/bootstrap/templates',
));
