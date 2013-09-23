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
	// Classes
	'Netzmacht\Bootstrap\Widget\SingleSelectSelectMenu'    => 'system/modules/bootstrap/classes/Widget/SingleSelectSelectMenu.php',
	'Netzmacht\Bootstrap\Helper\Gravatar'                  => 'system/modules/bootstrap/classes/Helper/Gravatar.php',
	'Netzmacht\Bootstrap\Helper\Icons'                     => 'system/modules/bootstrap/classes/Helper/Icons.php',
	'Netzmacht\Bootstrap\Helper\Buttons'                   => 'system/modules/bootstrap/classes/Helper/Buttons.php',
	'Netzmacht\Bootstrap\Attributes'                       => 'system/modules/bootstrap/classes/Attributes.php',
	'Netzmacht\Bootstrap\Model\ContentWrapper'             => 'system/modules/bootstrap/classes/Model/ContentWrapper.php',
	'Netzmacht\Bootstrap\Model\Collection\ContentWrapper'  => 'system/modules/bootstrap/classes/Model/Collection/ContentWrapper.php',
	'Netzmacht\Bootstrap\Template\Modifier'                => 'system/modules/bootstrap/classes/Template/Modifier.php',
	'Netzmacht\Bootstrap\Template\Modifier\Panel'          => 'system/modules/bootstrap/classes/Template/Modifier/Panel.php',
	'Netzmacht\Bootstrap\Template\Modifier\Layout'         => 'system/modules/bootstrap/classes/Template/Modifier/Layout.php',
	'Netzmacht\Bootstrap\Template\Modifier\Navigation'     => 'system/modules/bootstrap/classes/Template/Modifier/Navigation.php',
	'Netzmacht\Bootstrap\Ajax'                             => 'system/modules/bootstrap/classes/Ajax.php',
	'Netzmacht\Bootstrap\ContentElement\Button'            => 'system/modules/bootstrap/classes/ContentElement/Button.php',
	'Netzmacht\Bootstrap\ContentElement\Tab'               => 'system/modules/bootstrap/classes/ContentElement/Tab.php',
	'Netzmacht\Bootstrap\ContentElement\AccordionGroup'    => 'system/modules/bootstrap/classes/ContentElement/AccordionGroup.php',
	'Netzmacht\Bootstrap\ContentElement\ColumnSet'         => 'system/modules/bootstrap/classes/ContentElement/ColumnSet.php',
	'Netzmacht\Bootstrap\ContentElement\Carousel'          => 'system/modules/bootstrap/classes/ContentElement/Carousel.php',
	'Netzmacht\Bootstrap\ContentElement\Buttons'           => 'system/modules/bootstrap/classes/ContentElement/Buttons.php',
	'Netzmacht\Bootstrap\ContentElement\BootstrapAbstract' => 'system/modules/bootstrap/classes/ContentElement/BootstrapAbstract.php',
	'Netzmacht\Bootstrap\ContentElement\Wrapper'           => 'system/modules/bootstrap/classes/ContentElement/Wrapper.php',
	'Netzmacht\Bootstrap\Iterator\ArrayCallbackModify'     => 'system/modules/bootstrap/classes/Iterator/ArrayCallbackModify.php',
	'Netzmacht\Bootstrap\Iterator\ArrayOuter'              => 'system/modules/bootstrap/classes/Iterator/ArrayOuter.php',
	'Netzmacht\Bootstrap\Iterator\ArrayCallbackFilter'     => 'system/modules/bootstrap/classes/Iterator/ArrayCallbackFilter.php',
	'Netzmacht\Bootstrap\DataContainer\Bootstrap'          => 'system/modules/bootstrap/classes/DataContainer/Bootstrap.php',
	'Netzmacht\Bootstrap\DataContainer\Content'            => 'system/modules/bootstrap/classes/DataContainer/Content.php',
	'Netzmacht\Bootstrap\DataContainer\Layout'             => 'system/modules/bootstrap/classes/DataContainer/Layout.php',
	'Netzmacht\Bootstrap\DataContainer\General'            => 'system/modules/bootstrap/classes/DataContainer/General.php',
	'Netzmacht\Bootstrap\DataContainer\Module'             => 'system/modules/bootstrap/classes/DataContainer/Module.php',
	'Netzmacht\Bootstrap\DataContainer\Wrapper'            => 'system/modules/bootstrap/classes/DataContainer/Wrapper.php',
	'Netzmacht\Bootstrap\InsertTags'                       => 'system/modules/bootstrap/classes/InsertTags.php',
	'Netzmacht\Bootstrap\Module\Navbar'                    => 'system/modules/bootstrap/classes/Module/Navbar.php',
	'Netzmacht\Bootstrap\Module\Modal'                     => 'system/modules/bootstrap/classes/Module/Modal.php',
	'Netzmacht\Bootstrap\Module\BootstrapAbstract'         => 'system/modules/bootstrap/classes/Module/BootstrapAbstract.php',
	'Netzmacht\Bootstrap\Bootstrap'                        => 'system/modules/bootstrap/classes/Bootstrap.php',
	'Netzmacht\Bootstrap\Form\Button'                      => 'system/modules/bootstrap/classes/Form/Button.php',
	'Netzmacht\Bootstrap\Form\Widget'                      => 'system/modules/bootstrap/classes/Form/Widget.php',
	'Netzmacht\Bootstrap\Installer'                        => 'system/modules/bootstrap/classes/Installer.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'gallery_grid'           => 'system/modules/bootstrap/templates',
	'ce_bootstrap_columnset' => 'system/modules/bootstrap/templates',
	'mod_navbar_container'   => 'system/modules/bootstrap/templates',
	'ce_bootstrap_tab'       => 'system/modules/bootstrap/templates',
	'bootstrap_buttons'      => 'system/modules/bootstrap/templates',
	'ce_bootstrap_carousel'  => 'system/modules/bootstrap/templates',
	'mod_navbar'             => 'system/modules/bootstrap/templates',
	'form_checkbox_generate' => 'system/modules/bootstrap/templates',
	'form_radio_generate'    => 'system/modules/bootstrap/templates',
	'navbar_brand'           => 'system/modules/bootstrap/templates',
	'navbar'                 => 'system/modules/bootstrap/templates',
	'gallery_carousel'       => 'system/modules/bootstrap/templates',
	'com_bootstrap'          => 'system/modules/bootstrap/templates',
	'ce_bootstrap_button'    => 'system/modules/bootstrap/templates',
	'fe_bootstrap'           => 'system/modules/bootstrap/templates',
	'ce_bootstrap_buttons'   => 'system/modules/bootstrap/templates',
	'navbar_toggle'          => 'system/modules/bootstrap/templates',
	'ce_accordion_group'     => 'system/modules/bootstrap/templates',
	'mod_bootstrap_modal'    => 'system/modules/bootstrap/templates',
	'form_modal'             => 'system/modules/bootstrap/templates',
	'nav_bootstrap_dropdown' => 'system/modules/bootstrap/templates',
	'bootstrap_buttons_item' => 'system/modules/bootstrap/templates',
));
