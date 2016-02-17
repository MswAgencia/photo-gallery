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
		'use_image' => false,
		'gallery_cover_width' => 300,
		'gallery_cover_height' => 490,
		'gallery_cover_resize_mode' => 'resize',
		'default_gallery_photos_width' => 250,
		'default_gallery_photos_height' => 250,
		'default_gallery_photos_resize_mode' => 'resizeCrop',
		'gallery_cover_thumbnail_width' => 250,
		'gallery_cover_thumbnail_height' => 250,
		'gallery_cover_thumbnail_resize_mode' => 'resizeCrop',
		'apply_watermark_on_photos' => true,
		'watermark_filepath' => WWW_ROOT . 'img/watermark.png'
	],
	'Image' => [
		'Photos' => [
			'Thumbnails' => [
				'painel_thumbnail' => ['width' => 250, 'height' => 250, 'mode' => 'resizeCrop'],
			]
		]
	]
];
