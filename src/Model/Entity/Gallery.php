<?php
namespace PhotoGallery\Model\Entity;

use Cake\Collection\Collection;
use Cake\ORM\Entity;
use AppCore\Lib\ImageUploaderConfig;
use AppCore\Lib\Utility\StringUtility;

/**
 * Gallery Entity.
 */
class Gallery extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
      'id' => true,
      'name' => true,
      'slug' => true,
      'category_id' => true,
      'sort_order' => true,
      'category' => true,
      'cover' => true,
      'cover_thumbnail' => true,
      'description' => true,
      'status' => true,
      'photo_width' => true,
      'photo_height' => true,
      'photo_resize_mode' => true
    ];

    protected function _setName($name)
    {
      $stringHelper = new StringUtility();

      $this->set('slug', $stringHelper->slug($name));
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

    /**
     * [getPhotoConfig description]
     * @return [type] [description]
     */
    public function getPhotoConfig()
    {
      $config = new ImageUploaderConfig();
      $config->width = $this->photo_width;
      $config->height = $this->photo_height;
      $config->mode = $this->photo_resize_mode;

      return $config;
    }

    public function getPhotosSorted() {
      if(isset($this->photos) and !empty($this->photos)) {
        $photosCollection = new Collection($this->photos);

        return $photosCollection->sortBy(function ($photo){
          return $photo->sort_order;
        }, SORT_ASC)->toArray();
      }
      return [];
    }

    public function getCover() {
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
