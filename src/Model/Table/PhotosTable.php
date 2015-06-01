<?php
namespace PhotoGallery\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PhotoGallery\Model\Entity\Photo;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;

/**
 * Photos Model
 */
class PhotosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('pg_photos');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->belongsTo('Galleries', [
            'foreignKey' => 'gallery_id',
            'className' => 'PhotoGallery.Galleries'
        ]);
        $this->hasMany('PhotosThumbnails', [
            'foreignKey' => 'photo_id',
            'className' => 'PhotoGallery.PhotosThumbnails',
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
            ->allowEmpty('title')
            ->requirePresence('path', 'create')
            ->notEmpty('path')
            ->add('gallery_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('gallery_id', 'create')
            ->notEmpty('gallery_id')
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');
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
        $rules->add($rules->existsIn(['gallery_id'], 'Galleries'));
        return $rules;
    }

    /**
     * [addNewPhotosToGallery description]
     * @param [type] $id   [description]
     * @param array  $data [description]
     */
    public function addNewPhotosToGallery($id, array $data) {
        $galleryTable = TableRegistry::get('PhotoGallery.Galleries');
        $thumbnailTable = TableRegistry::get('PhotoGallery.PhotosThumbnails');
        $gallery = $galleryTable->get($id);

        $entities = [];
        foreach($data as $photoPath) {
            $entity = $this->newEntity(['path' => $photoPath['photo'], 'status' => 1, 'sort_order' => 0]);
            if($entity) {
                $entity->gallery_id = $gallery->id;
                $entity->status = 1;
                $entity = $this->save($entity);
                if($entity) {
                    $entities[] = $entity;
                }
            }
            foreach($photoPath['thumbnails'] as $photoThumbnail){
                $thumbEntity = $thumbnailTable->newEntity($photoThumbnail + ['photo_id' => $entity->id]);
                $thumbnailTable->save($thumbEntity);
            }
        }
        return $entities;
    }

    public function afterDelete(Event $event, Photo $photo, \ArrayObject $options) 
    {
        Cache::clear(false, 'photo_gallery_cache');
    }

    public function beforeSave(Event $event, Photo $photo, \ArrayObject $options)
    {
        Cache::clear(false, 'photo_gallery_cache');
    }
}
