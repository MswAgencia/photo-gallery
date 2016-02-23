<?php
namespace PhotoGallery\Model\Entity;

use PhotoGallery\Model\Entity\Entity;
use Cake\Utility\Inflector;

class Category extends Entity
{

  protected $_accessible = [
    '*' => true,
    'id' => false
  ];

  protected function _setName($name)
  {
    $slug = Inflector::slug($name, '-');
    $slug = strtolower($slug);
    $this->set('slug', $slug);

    return $name;
  }

  public function getStatusAsString()
  {
    switch($this->status) {
      case 0:
        return 'Inativo';
      case 1:
        return 'Ativo';
      default:
        return 'Inválido / Não definido';
    }
  }

  public function getGalleries()
  {
    return $this->galleries;
  }
}
