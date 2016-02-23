<?php
namespace PhotoGallery\Model\Entity;

use PhotoGallery\Model\Entity\Entity;

class PhotosThumbnail extends Entity
{
  protected $_accessible = [
    'path' => true,
    'photo_id' => true,
    'ref' => true
  ];
}
