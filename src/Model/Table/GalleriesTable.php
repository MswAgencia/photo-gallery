<?php
namespace PhotoGallery\Model\Table;

use Cake\Core\Plugin;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PhotoGallery\Model\Entity\Gallery;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Filesystem\File;

/**
 * Galleries Model
 */
class GalleriesTable extends Table
{

  /**
   * Initialize method
   *
   * @param array $config The configuration for the Table.
   * @return void
   */
  public function initialize(array $config)
  {
    $this->table('pg_galleries');
    $this->displayField('name');
    $this->primaryKey('id');
    $this->belongsTo('Categories', [
      'foreignKey' => 'category_id',
      'className' => 'PhotoGallery.Categories'
    ]);
    $this->hasMany('Photos', [
      'foreignKey' => 'gallery_id',
      'className' => 'PhotoGallery.Photos',
      'dependent' => true
    ]);

    if(Plugin::loaded('VideoManager')) {
      $this->hasMany('Videos', [
        'foreignKey' => 'gallery_id',
        'className' => 'VideoManager.Videos',
        'dependent' => true
      ]);
    }
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
      ->requirePresence('name', 'create')
      ->notEmpty('name')
      ->add('category_id', 'valid', ['rule' => 'numeric'])
      ->requirePresence('category_id', 'create')
      ->notEmpty('category_id')
      ->add('sort_order', 'valid', ['rule' => 'numeric'])
      ->allowEmpty('sort_order');

    if(Configure::read('WebImobApp.Plugins.PhotoGallery.Settings.Options.use_image')) {
      $validator
        ->requirePresence('cover', 'create')
        ->notEmpty('cover', '', 'create');
    }
    return $validator;
  }

  /**
   * Returns a rules checker object that will be used for validating
   * application integrity.
   *
   * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
   * @return \Cake\ORM\RulesChecker
   */
  public function buildRules(RulesChecker $rules)
  {
    $rules->add($rules->existsIn(['category_id'], 'Categories'));
    return $rules;
  }

  /**
   * [getGallery description]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function getGallery($id)
  {
    return $this->find()
      ->contain(['Categories', 'Photos.PhotosThumbnails.Photos'])
      ->where(['Galleries.id' => $id])
      ->where(['Galleries.status' => 1])
      ->cache(function ($q) {
          return 'pg_get_gallery-' . md5(serialize($q->clause('where')));
      }, 'photo_gallery_cache')
      ->first();
  }

  /**
   * [getAllGalleries description]
   * @return [type] [description]
   */
  public function getAllGalleries()
  {
      return $this->find()->all();
  }

  public function getAllActiveGalleries()
  {
    return $this->find()
      ->contain(['Photos' => function ($q) { return $q->where(['Photos.status' => 1]); }, 'Photos.PhotosThumbnails'])
      ->where(['Galleries.status' => 1])
      ->cache(function ($q) {
          return 'pg_get_all_active_galleries-' . md5(serialize($q->clause('where')));
      }, 'photo_gallery_cache')
      ->all();
  }

  /**
   * [insertNewGallery description]
   * @param  array  $data [description]
   * @return [type]       [description]
   */
  public function insertNewGallery(array $data)
  {
    $entity = $this->newEntity($data);

    return $this->save($entity);
  }

  public function updateGallery($id, $data)
  {
    $gallery = $this->get($id);

    $gallery = $this->patchEntity($gallery, $data);
    return $this->save($gallery);
  }

  /**
   * [deleteGallery description]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function deleteGallery($id)
  {
    $entity = $this->get($id);

    if(!$entity)
      throw new NotFoundException();

    return $this->delete($entity);
  }

  public function afterDelete(Event $event, Gallery $gallery, \ArrayObject $options)
  {
    if(!empty($gallery->cover)) {
      $file = new File(WWW_ROOT . 'img' . DS . $gallery->cover);
      $file->delete();
      $file->close();
    }
    Cache::clear(false, 'photo_gallery_cache');
  }

  public function beforeSave(Event $event, Gallery $gallery, \ArrayObject $options)
  {
    Cache::clear(false, 'photo_gallery_cache');
  }
}
