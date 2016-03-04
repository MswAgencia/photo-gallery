<?php

use Migrations\AbstractMigration;

class CreateCategoriesTable extends AbstractMigration {

  public function change()
  {
    $table = $this->table('pg_categories');
    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ])
    ->addPrimaryKey('id')
    ->addColumn('name', 'string')
    ->addColumn('slug', 'string')
    ->addColumn('sort_order', 'integer')
    ->addColumn('status', 'boolean')
    ->create();
  }
}
