<?php

$GLOBALS['STYLEPICKER_PRESET']['bootstrap'] = array(
	'label'   => 'Bootstrap 3',
	'classes' => array(
		/**
		 * Grid
		 */
		'container'        => array(
			'title' => 'Grid - Container',
			'ce'    => 'semantic_html5',
		),
		'container-fluid'  => array(
			'title' => 'Grid - Container Responsive',
			'ce'    => 'semantic_html5',
		),
		'row'              => array(
			'title' => 'Grid - Zeile',
			'ce'    => 'semantic_html5',
		),
		/**
		 * Text
		 */
		'text-left'        => array(
			'title' => 'Text - Links',
			'ce'    => '*',
		),
		'text-center'      => array(
			'title' => 'Text - Mittig',
			'ce'    => '*',
		),
		'text-right'       => array(
			'title' => 'Text - Rechts',
			'ce'    => '*',
		),
		'text-justify'     => array(
			'title' => 'Text - Blocksatz',
			'ce'    => '*',
		),
		'lead'             => array(
			'title' => 'Text - Aufmacher',
			'ce'    => '*',
		),
		'small'            => array(
			'title' => 'Text - Fußnotiz',
			'ce'    => '*',
		),
		/**
		 * Headline
		 */
		'h1'               => array(
			'title' => 'Überschrift - Level 1 Stil',
			'ce'    => '*',
		),
		'h2'               => array(
			'title' => 'Überschrift - Level 2 Stil',
			'ce'    => '*',
		),
		'h3'               => array(
			'title' => 'Überschrift - Level 3 Stil',
			'ce'    => '*',
		),
		'h4'               => array(
			'title' => 'Überschrift - Level 4 Stil',
			'ce'    => '*',
		),
		'h5'               => array(
			'title' => 'Überschrift - Level 5 Stil',
			'ce'    => '*',
		),
		'h6'               => array(
			'title' => 'Überschrift - Level 6 Stil',
			'ce'    => '*',
		),
		/**
		 * Table
		 */
		'table-striped'    => array(
			'title' => 'Tabelle - Linien',
			'ce'    => 'table',
		),
		'table-bordered'   => array(
			'title' => 'Tabelle - Umrahmt',
			'ce'    => 'table',
		),
		'table-hover'      => array(
			'title' => 'Tabelle - Hervorhebung',
			'ce'    => 'table',
		),
		'table-condensed'  => array(
			'title' => 'Tabelle - Platzsparent',
			'ce'    => 'table',
		),
		'table-responsive' => array(
			'title' => 'Tabelle - Responsive',
			'ce'    => 'table',
		),
		/**
		 * Buttons
		 */
		'btn-lg'           => array(
			'title' => 'Button - groß',
			'ce'    => array('bootstrap_button', 'bootstrap_buttons'),
		),
		'btn-sm'           => array(
			'title' => 'Button - leicht vergrößert',
			'ce'    => array('bootstrap_button', 'bootstrap_buttons'),
		),
		'btn-xs'           => array(
			'title' => 'Button - klein',
			'ce'    => array('bootstrap_button', 'bootstrap_buttons'),
		),
		/**
		 * Images
		 */
		'img-responsive'   => array(
			'title' => 'Bild - Responsive',
			'ce'    => '*',
		),
		'img-rounded'      => array(
			'title' => 'Bild - Abgerundet',
			'ce'    => '*',
		),
		'img-circle'       => array(
			'title' => 'Bild - Rund',
			'ce'    => '*',
		),
		'img-thumbnail'    => array(
			'title' => 'Bild - Eingerahmt',
			'ce'    => '*',
		),
		/**
		 * Contextual colors
		 */
		'text-muted'       => array(
			'title' => 'Text - Muted',
			'ce'    => '*',
		),
		'text-primary'     => array(
			'title' => 'Text - Primary',
			'ce'    => '*',
		),
		'text-success'     => array(
			'title' => 'Text - Success',
			'ce'    => '*',
		),
		'text-info'        => array(
			'title' => 'Text - Info',
			'ce'    => '*',
		),
		'text-warning'     => array(
			'title' => 'Text - Warning',
			'ce'    => '*',
		),
		'text-danger'      => array(
			'title' => 'Text - Danger',
			'ce'    => '*',
		),
		/**
		 * Contextual backgrounds
		 */
		'bg-primary'     => array(
			'title' => 'Hintergrund - Primary',
			'ce'    => '*',
		),
		'bg-success'     => array(
			'title' => 'Hintergrund - Success',
			'ce'    => '*',
		),
		'bg-info'        => array(
			'title' => 'Hintergrund - Info',
			'ce'    => '*',
		),
		'bg-warning'     => array(
			'title' => 'Hintergrund - Warning',
			'ce'    => '*',
		),
		'bg-danger'      => array(
			'title' => 'Hintergrund - Danger',
			'ce'    => '*',
		),
		/**
		 * Floating
		 */
		'pull-left'     => array(
			'title' => 'Umfließend - Links ausgerichtet',
			'ce'    => '*',
		),
		'pull-right'      => array(
			'title' => 'Umfließend - Rechts ausgerichtet',
			'ce'    => '*',
		),
		'center-block'      => array(
			'title' => 'Block - Mittig ausgerichtet',
			'ce'    => '*',
		),
		/**
		 * Accessibility
		 */
		'sr-only'      => array(
			'title' => 'Accessibility - Screen readers only',
			'ce'    => '*',
		),
		'visible-xs'      => array(
			'title' => 'Accessibility - Visible for extra small devices',
			'ce'    => '*',
		),
		'visible-sm'      => array(
			'title' => 'Accessibility - Visible for small devices',
			'ce'    => '*',
		),
		'visible-md'      => array(
			'title' => 'Accessibility - Visible for medium devices',
			'ce'    => '*',
		),
		'visible-lg'      => array(
			'title' => 'Accessibility - Visible for large devices',
			'ce'    => '*',
		),
		'hidden-xs'      => array(
			'title' => 'Accessibility - Invisible for extra small devices',
			'ce'    => '*',
		),
		'hidden-sm'      => array(
			'title' => 'Accessibility - Invisible for small devices',
			'ce'    => '*',
		),
		'hidden-md'      => array(
			'title' => 'Accessibility - Invisible for medium devices',
			'ce'    => '*',
		),
		'hidden-lg'      => array(
			'title' => 'Accessibility - Invisible for large devices',
			'ce'    => '*',
		),
		'visible-print'      => array(
			'title' => 'Accessibility - Visible for print',
			'ce'    => '*',
		),
		'hidden-print'      => array(
			'title' => 'Accessibility - Invisible for print',
			'ce'    => '*',
		),
	),
);
