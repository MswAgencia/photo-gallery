<?php

use AppCore\Lib\PluginStarter;
use Cake\Cache\Cache;

$starter = new PluginStarter();
$starter->load('PhotoGallery');

Cache::config('photo_gallery_cache', [
    'className' => 'Cake\Cache\Engine\FileEngine',
    'duration' => '+1 week',
    'probability' => 100,
    'path' => CACHE . 'plugins' . DS . 'photo_gallery' . DS,
]);