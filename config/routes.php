<?php
use Cake\Routing\Router;

Router::plugin('PhotoGallery', ['path' => '/interno/galeria-de-fotos'], function ($routes) {
	// categorias
	$routes->connect('/categorias', ['controller' => 'Categories', 'action' => 'index']);
	$routes->connect('/categorias/novo', ['controller' => 'Categories', 'action' => 'add']);
	$routes->connect('/categorias/editar/:id', ['controller' => 'Categories', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
	$routes->connect('/categorias/remover/:id', ['controller' => 'Categories', 'action' => 'delete'], ['id' => '\d+', 'pass' => ['id']]);

	// galerias
	$routes->connect('/galerias', ['controller' => 'Galleries', 'action' => 'index']);
	$routes->connect('/galerias/novo', ['controller' => 'Galleries', 'action' => 'add']);
	$routes->connect('/galerias/editar/:id', ['controller' => 'Galleries', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id']]);
	$routes->connect('/galerias/remover/:id', ['controller' => 'Galleries', 'action' => 'delete'], ['id' => '\d+', 'pass' => ['id']]);

	// fotos
	$routes->connect('/galerias/fotos/set_order', ['controller' => 'Photos', 'action' => 'setOrder']);
	$routes->connect('/galerias/:id/fotos/', ['controller' => 'Photos', 'action' => 'manage'], ['id' => '\d+', 'pass' => ['id']]);
	$routes->connect('/galerias/:id/fotos/adicionar/', ['controller' => 'Photos', 'action' => 'add'], ['id' => '\d+', 'pass' => ['id']]);
	$routes->connect('/galerias/:id/fotos/remover/:photo_id', ['controller' => 'Photos', 'action' => 'delete'], ['id' => '\d+', 'photo_id' => '\d+', 'pass' => ['id', 'photo_id']]);
});
