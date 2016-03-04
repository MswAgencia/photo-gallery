<?php

use Migrations\AbstractMigration;

class CreateCategoriesTable extends AbstractMigration {

  public function change()
  {
    $table = $this->table('pg_photos_thumbnails');
    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ])
    ->addPrimaryKey('id')
    ->addColumn('path', 'string')
    ->addColumn('ref', 'string')
    ->addColumn('photo_id', 'integer')
    ->create();
  }
}
