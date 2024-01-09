<?php

function generateModel($modelName)
{
    $modelName = ucfirst($modelName);
    $lowerCaseModelName = strtolower($modelName) . 's';
    $modelContent = <<<EOT
<?php

namespace app\models;

use app\core\Model;

class $modelName extends Model
{
    public function __construct()
    {
        parent::__construct('$lowerCaseModelName');
    }
}
    

EOT;

    file_put_contents("app/models/$modelName.php", $modelContent);

    echo "Model $modelName.php has been created in the app/models directory.\n";
}

// Get the controller name from the terminal argument
$modelName = $argv[1] ?? '';

if ($modelName) {
    generateModel($modelName);
} else {
    echo "Please provide a model name.\n";
}
