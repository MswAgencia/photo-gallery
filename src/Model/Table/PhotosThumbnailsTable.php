<?php
namespace PhotoGallery\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PhotoGallery\Model\Entity\PhotosThumbnail;
use Cake\Event\Event;
use Cake\Filesystem\File;

class PhotosThumbnailsTable extends Table
{
  public function initialize(array $config)
  {
    $this->table('pg_photos_thumbnails');
    $this->displayField('id');
    $this->primaryKey('id');
    $this->belongsTo('Photos', [
      'foreignKey' => 'photo_id',
      'className' => 'PhotoGallery.Photos',
      'dependent' => true
    ]);
  }

  /**
   * Default validation rules.
   *
   * @param \Cake\Validation\Validator $validator Validator instance.
   * @return \Cake\Validation\Validator
   */
  public function validationDefault(Validator $validator)
  {
    $validator
      ->add('id', 'valid', ['rule' => 'numeric'])
      ->allowEmpty('id', 'create')
      ->requirePresence('path', 'create')
      ->notEmpty('path')
      ->add('photo_id', 'valid', ['rule' => 'numeric'])
      ->requirePresence('photo_id', 'create')
      ->notEmpty('photo_id')
      ->requirePresence('ref', 'create')
      ->notEmpty('ref');

    return $validator;
  }

  public function afterDelete(Event $event, PhotoThumbnail $photo, \ArrayObject $config)
  {
    if(!empty($photo->path)) {
      $file = new File(WWW_ROOT . 'img' . DS . $photo->path);
      $file->delete();
      $file->close();
    }
  }
}
