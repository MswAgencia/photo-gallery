<?php
namespace PhotoGallery\Model\Entity;

use Cake\Collection\Collection;
use PhotoGallery\Model\Entity\Entity;
use Cake\Utility\Inflector;

class Gallery extends Entity
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

  public function getPhotosSorted()
  {
    if(isset($this->photos) and !empty($this->photos)) {
      $photosCollection = new Collection($this->photos);

      return $photosCollection->sortBy(function ($photo){
        return $photo->sort_order;
      }, SORT_ASC)->toArray();
    }
    return [];
  }

  public function getCover()
  {
    if(empty($this->cover))
      return 'Sem Imagem';

    return $this->cover;
  }

  public function getThumbnail()
  {
    if(empty($this->cover_thumbnail))
      return 'Sem Imagem';
    return $this->cover_thumbnail;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getVideos()
  {
    if(isset($this->videos))
      return $this->videos;
    return false;
  }
}
