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
