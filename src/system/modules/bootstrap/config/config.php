<?php

require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap.php';

/**
 * frontend modules
 */
$GLOBALS['FE_MOD']['navigationMenu']['bootstrap_navbar']            = 'Netzmacht\\Bootstrap\\ModuleNavbar';
$GLOBALS['FE_MOD']['miscellaneous']['bootstrap_modal']              = 'Netzmacht\\Bootstrap\\ModuleModal';


/**
 * content elements
 */
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselStart'] = 'Bootstrap\\ContentCarousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselPart']  = 'Bootstrap\\ContentCarousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselEnd']   = 'Bootstrap\\ContentCarousel';

$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabStart']          = 'Bootstrap\\ContentTab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabPart']           = 'Bootstrap\\ContentTab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabEnd']            = 'Bootstrap\\ContentTab';

$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupStart']    = 'Bootstrap\\ContentAccordionGroup';
$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupEnd']      = 'Bootstrap\\ContentAccordionGroup';

$GLOBALS['TL_CTE']['links']['bootstrap_button']                     = 'Bootstrap\\ContentButton';
$GLOBALS['TL_CTE']['links']['bootstrap_buttons']                    = 'Bootstrap\\ContentButtons';

$GLOBALS['TL_CTE']['subcolumns']['bootstrap_columnset']             = 'Bootstrap\\ContentColumnSet';


/**
 * form wigets
 */
$GLOBALS['TL_FFL']['button'] = 'Netzmacht\\Bootstrap\\FormButton';


/**
 * hooks
 */
if(version_compare(VERSION, '3.1', '>='))
{
	$GLOBALS['TL_HOOKS']['getPageLayout'][]     = array('Bootstrap\\Bootstrap', 'initializeLayout');
}
else
{
	$GLOBALS['TL_HOOKS']['parseTemplate'][]     = array('Bootstrap\\Bootstrap', 'initializeLayoutByParseTemplateHook');
}

$GLOBALS['TL_HOOKS']['loadFormField'][]         = array('Bootstrap\\Bootstrap', 'initializeFormWidget');
$GLOBALS['TL_HOOKS']['parseTemplate'][]         = array('Bootstrap\\TemplateModifier', 'execute');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][]     = array('Bootstrap\\InsertTags', 'replaceTags');
$GLOBALS['TL_HOOKS']['simpleAjax'][]            = array('Bootstrap\\Ajax', 'loadModalContent');


/**
 * config values
 */
$GLOBALS['TL_CONFIG']['bootstrapIconSet'] = 'font-awesome'; //'glyphicons';


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
// add stylesheet for indented elements
if(TL_MODE == 'BE' && version_compare(VERSION, '3.1', '>='))
{
	$GLOBALS['TL_CSS'][] = 'system/modules/bootstrap/assets/css/style.css|all|static';
}


$GLOBALS['TL_CONFIG']['gravatarSize'] = '60';