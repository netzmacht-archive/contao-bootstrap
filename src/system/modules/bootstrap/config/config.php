<?php

require_once TL_ROOT . '/system/modules/bootstrap/config/bootstrap.php';

/**
 * backend modules
 */


/**
 * frontend modules
 */
$GLOBALS['FE_MOD']['navigationMenu']['bootstrap_navbar'] = 'Netzmacht\\Bootstrap\\ModuleNavbar';


/**
 * content elements
 */
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselStart'] = 'Bootstrap\\ContentCarousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselPart']  = 'Bootstrap\\ContentCarousel';
$GLOBALS['TL_CTE']['bootstrap_carousel']['bootstrap_carouselEnd']   = 'Bootstrap\\ContentCarousel';

$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabStart']      = 'Bootstrap\\ContentTab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabPart']       = 'Bootstrap\\ContentTab';
$GLOBALS['TL_CTE']['bootstrap_tabs']['bootstrap_tabEnd']        = 'Bootstrap\\ContentTab';

$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupStart']      = 'Bootstrap\\ContentAccordionGroup';
$GLOBALS['TL_CTE']['accordion']['bootstrap_accordionGroupEnd']        = 'Bootstrap\\ContentAccordionGroup';

$GLOBALS['TL_CTE']['links']['bootstrap_button']                 = 'Bootstrap\\ContentButton';
$GLOBALS['TL_CTE']['subcolumns']['bootstrap_columnset']         = 'Bootstrap\\ContentColumnSet';


/**
 * form wigets
 */
$GLOBALS['TL_FFL']['button'] = 'Netzmacht\\Bootstrap\\FormButton';


/**
 * hooks
 */
if(version_compare(VERSION, '3.1', '>0'))
{
	$GLOBALS['TL_HOOKS']['getPageLayout'][] = array('Bootstrap\\DataContainer\\Bootstrap', 'initializeLayout');
}
else
{
	$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('Bootstrap\\DataContainer\\Bootstrap', 'initializeLayoutByParseTemplateHook');
}

$GLOBALS['TL_HOOKS']['loadFormField'][] = array('Bootstrap\\DataContainer\\Bootstrap', 'initializeFormWidget');
$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('Bootstrap\\DataContainer\\Bootstrap', 'callTemplateModifiers');

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


/**
 * stylesheets
 */
// add stylesheet for indented elements
if(TL_MODE == 'BE' && version_compare(VERSION, '3.1', '>=')) {
	$GLOBALS['TL_CSS'][] = 'system/modules/bootstrap/assets/css/style.css|all|static';
}