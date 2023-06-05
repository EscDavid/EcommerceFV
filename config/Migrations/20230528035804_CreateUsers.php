<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
   
        public function change(): void
        {
    
    
            $table = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
    
            $table->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 5
            ]);
            $table->addColumn('name', 'string', [
                'limit' => 60,
                'null' => false,
            ]);
            $table->addColumn('lastname', 'string', [
                'limit' => 60,
                'null' => false,
            ]);
            $table->addColumn('email', 'string', [
                'limit' => 120,
                'null' => false,
            ]);
            $table->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ]);
            
            $table->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ]);
            
            $table->addPrimaryKey("id");
            $table->create();
        
    }
}
