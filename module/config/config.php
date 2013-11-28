<?php

require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap/assets.php';
require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap/layout.php';
require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap/form.php';
require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap/templates.php';
require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap/wrappers.php';
require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap/miscellaneous.php';


/**
 * frontend modules
 */
$GLOBALS['FE_MOD']['navigationMenu']['bootstrap_navbar']            = 'Netzmacht\Bootstrap\Module\Navbar';
$GLOBALS['FE_MOD']['miscellaneous']['bootstrap_modal']              = 'Netzmacht\Bootstrap\Module\Modal';


$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_bootstrap';


/**
 * content elements
 */
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselStart'] = 'Netzmacht\Bootstrap\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselPart']  = 'Netzmacht\Bootstrap\ContentElement\Carousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselEnd']   = 'Netzmacht\Bootstrap\ContentElement\Carousel';

$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabStart']          = 'Netzmacht\Bootstrap\ContentElement\Tab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabPart']           = 'Netzmacht\Bootstrap\ContentElement\Tab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabEnd']            = 'Netzmacht\Bootstrap\ContentElement\Tab';

$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupStart']    = 'Netzmacht\Bootstrap\ContentElement\AccordionGroup';
$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupEnd']      = 'Netzmacht\Bootstrap\ContentElement\AccordionGroup';

$GLOBALS['TL_CTE']['links']['bootstrap_button']                     = 'Netzmacht\Bootstrap\ContentElement\Button';
$GLOBALS['TL_CTE']['links']['bootstrap_buttons']                    = 'Netzmacht\Bootstrap\ContentElement\Buttons';

$GLOBALS['TL_CTE']['subcolumns']['bootstrap_columnset']             = 'Netzmacht\Bootstrap\ContentElement\ColumnSet';


/**
 * form wigets
 */
$GLOBALS['TL_FFL']['button'] = 'Netzmacht\Bootstrap\Form\Button';

/**
 * backend widgets
 */
$GLOBALS['BE_FFL']['singleSelect']              = 'Netzmacht\Bootstrap\Widget\SingleSelectSelectMenu';


/**
 * hooks
 */

$GLOBALS['TL_HOOKS']['initializeSystem'][]      = array('Netzmacht\Bootstrap\Bootstrap', 'initializeConfig');
$GLOBALS['TL_HOOKS']['getPageLayout'][]         = array('Netzmacht\Bootstrap\Bootstrap', 'initializeLayout');
$GLOBALS['TL_HOOKS']['loadFormField'][]         = array('Netzmacht\Bootstrap\Bootstrap', 'initializeFormWidget');

$GLOBALS['TL_HOOKS']['parseTemplate'][]         = array('Netzmacht\Bootstrap\Template\Modifier', 'execute');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][]     = array('Netzmacht\Bootstrap\InsertTags', 'replaceTags');
$GLOBALS['TL_HOOKS']['simpleAjax'][]            = array('Netzmacht\Bootstrap\Ajax', 'loadModalContent');


/**
 * wrapper
 */
$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_accordionGroupStart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_accordionGroupEnd';

$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_tabStart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_tabEnd';
$GLOBALS['TL_WRAPPERS']['separator'][]  = 'bootstrap_tabPart';

$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_carouselStart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_carouselEnd';
$GLOBALS['TL_WRAPPERS']['separator'][]  = 'bootstrap_carouselPart';

$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_buttonToolbarStart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_buttonToolbarEnd';

$GLOBALS['TL_WRAPPERS']['start'][]      = 'bootstrap_buttonGroupStart';
$GLOBALS['TL_WRAPPERS']['stop'][]       = 'bootstrap_buttonGroupEnd';


/**
 * stylesheets
 */
if(TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS']['bootstrap'] = 'system/modules/bootstrap/assets/css/backend.css|all|static';

	// @see xat/contao-customselectmenu #6
	$GLOBALS['TL_JAVASCRIPT']['customselectmenu'] = 'system/modules/customselectmenu/html/js/customselectmenu.min.js';
}


$GLOBALS['TL_CONFIG']['gravatarSize'] = '60';