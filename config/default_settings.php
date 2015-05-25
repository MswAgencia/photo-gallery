<?php
use Cake\Core\Configure;

$config['WebImobApp.Plugins.PhotoGallery.Settings'] = [
	'General' => ['display_panel_menu' => true],
	'Template' => [
		'layout' => Configure::read('WebImobApp.Plugins.ControlPanel.Settings.Template.layout'), 
		'theme' => Configure::read('WebImobApp.Plugins.ControlPanel.Settings.Template.theme')
		],
	'Options' => [
		'use_order_field' => false,
		'use_image' => false
	],
	'Image' => [
		'Photos' => [
			'Thumbnails' => [
				'painel_thumbnail' => ['width' => 250, 'height' => 250, 'mode' => 'resizeCrop'],
			]
		]
	]
];