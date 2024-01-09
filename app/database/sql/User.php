<?php

use app\core\{Model};

require_once 'app/init.php';

class User extends Model
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        $fields = [
            'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
            'username' => 'VARCHAR(255)',
            'email' => 'VARCHAR(255)',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];

        $this->createTable('users', $fields);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropTable('users',);
    }
}