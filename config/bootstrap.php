<?php

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Cache\Cache;

$configDir = dirname(__FILE__) . DS;

try {
  if(file_exists(CONFIG . '/photo_gallery.php')) {
    Configure::load('photo_gallery', 'default', false);
  }
  else {
    Configure::config('photo_gallery_config', new PhpConfig($configDir));
    Configure::load('default_settings', 'photo_gallery_config', false);
    Configure::drop('photo_gallery_config');
  }
}
catch(\Exception $e) {
  die($e->getMessage());
}

Cache::config('photo_gallery_cache', [
    'className' => 'Cake\Cache\Engine\FileEngine',
    'duration' => '+1 week',
    'probability' => 100,
    'path' => CACHE . 'plugins' . DS . 'photo_gallery' . DS,
]);
