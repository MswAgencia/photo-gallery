<?php
namespace PhotoGallery\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use PhotoGallery\Model\Table\PhotosThumbnailsTable;

/**
 * PhotoGallery\Model\Table\PhotosThumbnailsTable Test Case
 */
class PhotosThumbnailsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'PhotosThumbnails' => 'plugin.photo_gallery.photos_thumbnails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PhotosThumbnails') ? [] : ['className' => 'PhotoGallery\Model\Table\PhotosThumbnailsTable'];
        $this->PhotosThumbnails = TableRegistry::get('PhotosThumbnails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PhotosThumbnails);

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
}
