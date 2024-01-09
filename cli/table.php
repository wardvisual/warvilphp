<?php

function generateTable($tableName)
{
    $tableName = ucfirst($tableName);
    $lowerCaseTableName = strtolower($tableName) . 's';
    $tableContent = <<<EOT
<?php

use app\core\{Model};

require_once 'app/init.php';

class $tableName extends Model
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \$this->down();
        \$fields = [
            'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];

        \$this->createTable('$lowerCaseTableName', \$fields);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \$this->dropTable('$lowerCaseTableName');
    }
}  

EOT;

    file_put_contents("app/database/sql/$tableName.php", $tableContent);

    echo "Table $tableName.php has been created in the app/database/sql directory.\n";
}

$tableName = $argv[1] ?? '';

if ($tableName) {
    generateTable($tableName);
} else {
    echo "Please provide a table name.\n";
}
