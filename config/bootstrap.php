<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;

if(file_exists(CONFIG . '/photo_gallery.php'))
  Configure::load(CONFIG . '/photo_gallery.php');
else
  Configure::load(dirname(__FILE__) . '/default_settings.php');

Cache::config('photo_gallery_cache', [
    'className' => 'Cake\Cache\Engine\FileEngine',
    'duration' => '+1 week',
    'probability' => 100,
    'path' => CACHE . 'plugins' . DS . 'photo_gallery' . DS,
]);
