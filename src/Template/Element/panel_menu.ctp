<?php

$items = [
    ['title' => 'Categorias', 'url' => '/interno/galeria-de-fotos/categorias', 'icon' => ''],
    ['title' => 'Galerias', 'url' => '/interno/galeria-de-fotos/galerias', 'icon' => ''],
];

echo $this->PanelMenu->createSecondLevelMenuTree('Galeria de Fotos', 'photo', $items);