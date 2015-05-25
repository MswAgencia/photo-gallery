<?php
namespace PhotoGallery\Model\Entity;

use Cake\ORM\Entity;

/**
 * PhotosThumbnail Entity.
 */
class PhotosThumbnail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'path' => true,
        'photo_id' => true,
        'ref' => true
    ];
}
