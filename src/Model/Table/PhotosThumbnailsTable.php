<?php
namespace PhotoGallery\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PhotoGallery\Model\Entity\PhotosThumbnail;

/**
 * PhotosThumbnails Model
 */
class PhotosThumbnailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('pg_photos_thumbnails');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Photos', [
            'foreignKey' => 'photo_id',
            'className' => 'PhotoGallery.Photos'
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
}
