<?php
namespace PhotoGallery\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use PhotoGallery\Model\Table\GalleriesTable;

/**
 * PhotoGallery\Model\Table\GalleriesTable Test Case
 */
class GalleriesTableTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Galleries' => 'plugin.photo_gallery.galleries',
        'Categories' => 'plugin.photo_gallery.categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Galleries') ? [] : ['className' => 'PhotoGallery\Model\Table\GalleriesTable'];
        $this->Galleries = TableRegistry::get('Galleries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Galleries);

        parent::tearDown();
    }

    /**
     * 
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'name' => '',
            'sort_order' => 1
        ];

        $entity = $this->Categories->newEntity($data);

        $this->assertEquals(false, empty($entity->errors('name')));
    }

    /**
     * [testIfSlugIsUnique description]
     * @return [type] [description]
     */
    public function testIfSlugIsUnique() {
        $data = [
            'name' => 'My Unique Slug',
            'sort_order' => 0
        ];

        $result = $this->Categories->insertNewGallery($data);

        $expected = [
            'id' => 1,
            'name' => 'My Unique Slug',
            'sort_order' => 0,
            'slug' => 'my-unique-slug'
        ];
        $this->assertEquals($expected, $result->toArray());


        $result = $this->Categories->insertNewGallery($data);

        $this->assertEquals(false, $result);
    }

    /**
     * [testMethodinsertNewGallery description]
     * @return [type] [description]
     */
    public function testMethodinsertNewGallery() {
        $data = [
            'name' => 'New Gallery Test',
            'sort_order' => 0
        ];

        $result = $this->Categories->insertNewGallery($data);

        $expected = [
            'id' => 1,
            'name' => 'New Gallery Test',
            'sort_order' => 0,
            'slug' => 'new-gallery-test'
        ];
        $this->assertEquals($expected, $result->toArray());
    }

    /**
     * [testMethodDeleteCategorySuccess description]
     * @return [type] [description]
     */
    public function testMethodDeleteGallerySuccess() {
        $data = [
            'name' => 'New Gallery Test',
            'sort_order' => 0
        ];

        $result = $this->Categories->insertNewGallery($data);

        $delete = $this->Categories->deleteGallery($result->id);
        $this->assertTrue($delete);
    }

    /**
     * [testMethodDeleteCategoryWithInexistentId description]
     * @return [type] [description]
     */
    public function testMethodDeleteGalleryWithInexistentId() {
        try {
            $delete = $this->Categories->deleteGallery(391);
        }
        catch(\Cake\Datasource\Exception\RecordNotFoundException $e) {
            return true;
        }
        $this->fail('Didn\'t throw the expected exception.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
