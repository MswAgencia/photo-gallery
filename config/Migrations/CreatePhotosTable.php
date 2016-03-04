<?php

use Migrations\AbstractMigration;

class CreatePhotosTable extends AbstractMigration {

  public function change()
  {
    $table = $this->table('pg_photos');
    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ])
    ->addPrimaryKey('id')
    ->addColumn('title', 'string')
    ->addColumn('description', 'text')
    ->addColumn('path', 'string')
    ->addColumn('gallery_id', 'integer')
    ->addColumn('status', 'boolean')
    ->addColumn('sort_order', 'integer')
    ->create();
  }
}
