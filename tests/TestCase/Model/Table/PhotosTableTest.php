<?php
namespace PhotoGallery\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use PhotoGallery\Model\Table\PhotosTable;

/**
 * PhotoGallery\Model\Table\PhotosTable Test Case
 */
class PhotosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Photos' => 'plugin.photo_gallery.photos',
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
        $config = TableRegistry::exists('Photos') ? [] : ['className' => 'PhotoGallery\Model\Table\PhotosTable'];
        $this->Photos = TableRegistry::get('Photos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Photos);

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
}
