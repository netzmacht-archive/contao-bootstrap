<?php

$GLOBALS['STYLEPICKER_PRESET']['bootstrap'] = array(
	'label'   => 'Bootstrap 3',
	'classes' => array(
		/**
		 * Grid
		 */
		'container'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['container'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['container'][1],
			'ce'          => 'semantic_html5',
		),
		'container-fluid'  => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['container-fluid'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['container-fluid'][1],
			'ce'          => 'semantic_html5',
		),
		'row'              => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['row'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['row'][1],
			'ce'          => 'semantic_html5',
		),
		/**
		 * Text
		 */
		'text-left'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-left'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-left'][1],
			'ce'          => '*',
		),
		'text-center'      => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-center'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-center'][1],
			'ce'          => '*',
		),
		'text-right'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-right'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-right'][1],
			'ce'          => '*',
		),
		'text-justify'     => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-justify'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-justify'][1],
			'ce'          => '*',
		),
		'lead'             => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['lead'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['lead'][1],
			'ce'          => '*',
		),
		'small'            => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['small'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['small'][1],
			'ce'          => '*',
		),
		/**
		 * Headline
		 */
		'h1'               => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h1'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h1'][1],
			'ce'          => '*',
		),
		'h2'               => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h2'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h2'][1],
			'ce'          => '*',
		),
		'h3'               => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h3'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h3'][1],
			'ce'          => '*',
		),
		'h4'               => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h4'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h4'][1],
			'ce'          => '*',
		),
		'h5'               => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h5'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h5'][1],
			'ce'          => '*',
		),
		'h6'               => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h6'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['h6'][1],
			'ce'          => '*',
		),
		/**
		 * Table
		 */
		'table-striped'    => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-striped'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-striped'][1],
			'ce'          => 'table',
		),
		'table-bordered'   => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-bordered'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-bordered'][1],
			'ce'          => 'table',
		),
		'table-hover'      => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-hover'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-hover'][1],
			'ce'          => 'table',
		),
		'table-condensed'  => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-condensed'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-condensed'][1],
			'ce'          => 'table',
		),
		'table-responsive' => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-responsive'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['table-responsive'][1],
			'ce'          => 'table',
		),
		/**
		 * Buttons
		 */
		'btn-lg'           => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['btn-lg'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['btn-lg'][1],
			'ce'          => array('bootstrap_button', 'bootstrap_buttons'),
		),
		'btn-sm'           => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['btn-sm'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['btn-sm'][1],
			'ce'          => array('bootstrap_button', 'bootstrap_buttons'),
		),
		'btn-xs'           => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['btn-xs'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['btn-xs'][1],
			'ce'          => array('bootstrap_button', 'bootstrap_buttons'),
		),
		/**
		 * Images
		 */
		'img-responsive'   => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-responsive'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-responsive'][1],
			'ce'          => '*',
		),
		'img-rounded'      => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-rounded'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-rounded'][1],
			'ce'          => '*',
		),
		'img-circle'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-circle'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-circle'][1],
			'ce'          => '*',
		),
		'img-thumbnail'    => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-thumbnail'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['img-thumbnail'][1],
			'ce'          => '*',
		),
		/**
		 * Contextual colors
		 */
		'text-muted'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-muted'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-muted'][1],
			'ce'          => '*',
		),
		'text-primary'     => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-primary'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-primary'][1],
			'ce'          => '*',
		),
		'text-success'     => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-success'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-success'][1],
			'ce'          => '*',
		),
		'text-info'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-info'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-info'][1],
			'ce'          => '*',
		),
		'text-warning'     => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-warning'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-warning'][1],
			'ce'          => '*',
		),
		'text-danger'      => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-danger'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['text-danger'][1],
			'ce'          => '*',
		),
		/**
		 * Contextual backgrounds
		 */
		'bg-primary'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-primary'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-primary'][1],
			'ce'          => '*',
		),
		'bg-success'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-success'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-success'][1],
			'ce'          => '*',
		),
		'bg-info'          => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-info'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-info'][1],
			'ce'          => '*',
		),
		'bg-warning'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-warning'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-warning'][1],
			'ce'          => '*',
		),
		'bg-danger'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-danger'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['bg-danger'][1],
			'ce'          => '*',
		),
		/**
		 * Floating
		 */
		'pull-left'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['pull-left'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['pull-left'][1],
			'ce'          => '*',
		),
		'pull-right'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['pull-right'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['pull-right'][1],
			'ce'          => '*',
		),
		'center-block'     => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['center-block'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['center-block'][1],
			'ce'          => '*',
		),
		/**
		 * Accessibility
		 */
		'sr-only'          => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['sr-only'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['sr-only'][1],
			'ce'          => '*',
		),
		'visible-xs'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-xs'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-xs'][1],
			'ce'          => '*',
		),
		'visible-sm'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-sm'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-sm'][1],
			'ce'          => '*',
		),
		'visible-md'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-md'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-md'][1],
			'ce'          => '*',
		),
		'visible-lg'       => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-lg'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-lg'][1],
			'ce'          => '*',
		),
		'hidden-xs'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-xs'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-xs'][1],
			'ce'          => '*',
		),
		'hidden-sm'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-sm'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-sm'][1],
			'ce'          => '*',
		),
		'hidden-md'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-md'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-md'][1],
			'ce'          => '*',
		),
		'hidden-lg'        => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-lg'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-lg'][1],
			'ce'          => '*',
		),
		'visible-print'    => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-print'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['visible-print'][1],
			'ce'          => '*',
		),
		'hidden-print'     => array(
			'title'       => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-print'][0],
			'description' => &$GLOBALS['TL_LANG']['BOOTSTRAP']['stylepicker']['hidden-print'][1],
			'ce'          => '*',
		),
	),
);
