<?php
namespace PhotoGallery\Model\Table;

use Cake\Core\Plugin;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PhotoGallery\Model\Entity\Category;
use Cake\Cache\Cache;
use Cake\Event\Event;

/**
 * Categories Model
 */
class CategoriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('pg_categories');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Galleries', [
            'foreignKey' => 'category_id',
            'className' => 'PhotoGallery.Galleries',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('sort_order', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('sort_order');

        return $validator;
    }

    /**
     * [buildRules description]
     * @param  RulesChecker $rules [description]
     * @return [type]              [description]
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['slug'], 'Categories'));
        return $rules;
    }

    /**
     * [insertNewCategory description]
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function insertNewCategory(array $data) {
        $entity = $this->newEntity($data);

        return $this->save($entity);
    }

    /**
     * [getAllCategories description]
     * @return [type] [description]
     */
    public function getAllCategories() {
        return $this->find()->all();
    }

    /**
     * [deleteCategory description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteCategory($id) {
        $entity = $this->get($id);

        if(!$entity)
            throw new NotFoundException();

        return $this->delete($entity);
    }

    /**
     * [getCategoriesAsList description]
     * @todo Implementar testes.
     * @return [type] [description]
     */
    public function getCategoriesAsList() {
        return $this->find('list',
            ['keyField' => 'id', 'valueField' => 'name'])
            ->toArray();
    }

    /**
     * [getAllCategoriesActive description]
     * @return [type] [description]
     */
    public function getAllActiveCategories() {
        $query = $this->find();

        if(Plugin::loaded('VideoManager'))
            $query->contain(['Galleries.Videos']);

        return $query->contain([
                'Galleries' => function ($q) { return $q->where(['Galleries.status' => 1]); },
                'Galleries.Photos' => function ($q) { return $q->where(['Photos.status' => 1])->order(['Photos.sort_order' => 'ASC']); },
                'Galleries.Photos.PhotosThumbnails'])
            ->where(['Categories.status' => 1])
            ->cache(function ($q){
                return 'pg_get_all_active_cat-' . md5(serialize($q->clause('where')));
            }, 'photo_gallery_cache')
            ->all();
    }

    public function getCategory($id) {
        $query = $this->find();

        $contain = ['Galleries.Photos.PhotosThumbnails'];

        if(Plugin::loaded('VideoManager'))
            $contain[] = ['Galleries.Videos'];

        $query->contain($contain);
        $query->matching('Galleries', function ($q) { return $q->where(['Galleries.status' => 1]); })
            ->matching('Galleries.Photos', function ($q) { return $q->where(['Photos.status' => 1]); })
            ->where(['Categories.status' => 1, 'Categories.slug' => $id])
            ->cache(function ($q){
                return 'pg_get_category-' . md5(serialize($q->clause('where')));
            }, 'photo_gallery_cache')
            ->first();
    }

    public function afterDelete(Event $event, Category $category, \ArrayObject $options) {
        Cache::clear(false, 'photo_gallery_cache');
    }

    public function beforeSave(Event $event, Category $category, \ArrayObject $options)
    {
        Cache::clear(false, 'photo_gallery_cache');
    }
}
