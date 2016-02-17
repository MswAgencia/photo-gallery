<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;


if(file_exists(CONFIG . '/banners_manager.php'))
  Configure::load(CONFIG . '/banners_manager.php');
else
  Configure::load(dirname(__FILE__) . '/default_settings.php');

Cache::config('photo_gallery_cache', [
    'className' => 'Cake\Cache\Engine\FileEngine',
    'duration' => '+1 week',
    'probability' => 100,
    'path' => CACHE . 'plugins' . DS . 'photo_gallery' . DS,
]);
