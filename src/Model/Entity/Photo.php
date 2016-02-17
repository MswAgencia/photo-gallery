<?php
namespace PhotoGallery\Model\Entity;

use AppCore\Model\Entity\Entity;

/**
 * Photo Entity.
 */
class Photo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'title' => true,
        'path' => true,
        'description' => true,
        'gallery_id' => true,
        'gallery' => true,
        'status' => true,
        'sort_order' => true
    ];

    /**
     * [getStatusAsString description]
     * @return [type] [description]
     */
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

    /**
     * [getPainelThumbnail description]
     * @return [type] [description]
     */
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
