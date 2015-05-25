<?php
namespace PhotoGallery\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use PhotoGallery\Controller\CategoriesController;
use Cake\ORM\TableRegistry;

/**
 * PhotoGallery\Controller\CategoriesController Test Case
 */
class CategoriesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Categories' => 'plugin.photo_gallery.pg_categories'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/interno/galeria-de-fotos/categorias');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testEditInexistentCategoryFails() {
        $this->get('/interno/galeria-de-fotos/categorias/editar/8473');
        $this->assertRedirect('/interno/galeria-de-fotos/categorias');
    }
    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $data = [
            'name' => 'This is a Test',
            'status' => 1
        ];

        $this->post('/interno/galeria-de-fotos/categorias/novo', $data);

        $this->assertResponseSuccess();
        $categoriesTable = TableRegistry::get('PhotoGallery.Categories');
        $query = $categoriesTable->find()->where(['name' => $data['name'], 'status' => $data['status']]);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
