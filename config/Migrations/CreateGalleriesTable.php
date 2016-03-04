<?php

use Migrations\AbstractMigration;

class CreatePhotosTable extends AbstractMigration {

  public function change()
  {
    $table = $this->table('pg_galleries');
    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ])
    ->addPrimaryKey('id')
    ->addColumn('name', 'string')
    ->addColumn('slug', 'string')
    ->addColumn('category_id', 'integer')
    ->addColumn('sort_order', 'integer')
    ->addColumn('cover', 'string')
    ->addColumn('description', 'text')
    ->addColumn('status', 'boolean')
    ->addColumn('photo_width', 'integer')
    ->addColumn('photo_height', 'integer')
    ->addColumn('photo_resize_mode', 'string')
    ->create();
  }
}
