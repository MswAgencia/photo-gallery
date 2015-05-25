<?php
namespace PhotoGallery\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use PhotoGallery\Model\Table\CategoriesTable;

/**
 * PhotoGallery\Model\Table\CategoriesTable Test Case
 */
class CategoriesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Categories') ? [] : ['className' => 'PhotoGallery\Model\Table\CategoriesTable'];
        $this->Categories = TableRegistry::get('Categories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Categories);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
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

    /**
     * Test insertNewCategory method
     *
     * @return void
     */
    public function testInsertNewCategory()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getAllCategories method
     *
     * @return void
     */
    public function testGetAllCategories()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test deleteCategory method
     *
     * @return void
     */
    public function testDeleteCategory()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getCategoriesAsList method
     *
     * @return void
     */
    public function testGetCategoriesAsList()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getAllActiveCategories method
     *
     * @return void
     */
    public function testGetAllActiveCategories()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getCategory method
     *
     * @return void
     */
    public function testGetCategory()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
