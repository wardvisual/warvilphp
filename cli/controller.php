<?php

function generateController($controllerName)
{
    $controllerName = ucfirst($controllerName);
    $lowerCaseControllerName = strtolower($controllerName);
    $controllerContent = <<<EOT
<?php

use \\app\\core\\Controller;

class $controllerName extends Controller
{
    /**
     * Display the index page.
     */
    public function index(): void
    {
        \$this->view('$lowerCaseControllerName/index');
    }
}

EOT;

    file_put_contents("app/controllers/$controllerName.php", $controllerContent);

    echo "Controller $controllerName.php has been created in the app/controllers directory.\n";
}

// Get the controller name from the terminal argument
$controllerName = $argv[1] ?? '';

if ($controllerName) {
    generateController($controllerName);
} else {
    echo "Please provide a controller name.\n";
}
