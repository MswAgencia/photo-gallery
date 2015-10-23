<?php
namespace PhotoGallery\Model\Entity;

use AppCore\Model\Entity\Entity;

/**
 * Category Entity.
 */
class Category extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'name' => true,
        'sort_order' => true,
        'status' => true
    ];

    protected function _setName($name) {
        $stringHelper = new \AppCore\Lib\Utility\StringUtility();

        $this->set('slug', $stringHelper->slug($name));
        return $name;
    }

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

    public function getGalleries(){
        return $this->galleries;
    }
}
