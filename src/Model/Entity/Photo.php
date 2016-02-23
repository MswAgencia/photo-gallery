<?php
namespace PhotoGallery\Model\Entity;

use PhotoGallery\Model\Entity\Entity;

class Photo extends Entity
{
  protected $_accessible = [
    '*' => true,
    'id' => false
  ];

  public function getStatusAsString() {
    switch($this->status) {
      case 0:
        return 'Inativo';
      case 1:
        return 'Ativo';
      default:
        return 'Inválido / Não definido';
    }
  }

  public function getPainelThumbnail() {
    foreach($this->photos_thumbnails as $thumbnail) {
      if($thumbnail->ref === 'painel_thumbnail')
        return $thumbnail;
    }
  }

  public function getTitle() {
    return $this->title;
  }

  public function getDescription() {
    return $this->description;
  }
}
