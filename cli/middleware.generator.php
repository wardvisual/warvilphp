<?php

function generateMiddleware($middlewareName)
{
    $middlewareName = ucfirst($middlewareName);
    $middlewareContent = <<<EOT
<?php

namespace app\middlewares;

use app\core\Request;
use app\core\Response;

class $middlewareName
{
    /**
     * Handle the incoming request.
     *
     * @param \app\core\Request \$request
     * @param \Closure \$next
     * @return mixed
     */
    public function handle(Request \$request, \$next)
    {
        // Middleware logic goes here
        // Example: Check if user is authenticated
        
        // To proceed with the request, call the next middleware:
        return \$next(\$request);
        
        // To stop the request and return a response:
        // return Response::json(['error' => 'Unauthorized'], 401);
    }
}
EOT;

    // Create middlewares directory if it doesn't exist
    if (!is_dir("app/middlewares")) {
        mkdir("app/middlewares", 0755, true);
    }

    file_put_contents("app/middlewares/$middlewareName.php", $middlewareContent);

    echo "Middleware $middlewareName.php has been created in the app/middlewares directory.\n";
}

// Get the middleware name from the terminal argument
$middlewareName = $argv[1] ?? '';

if ($middlewareName) {
    generateMiddleware($middlewareName);
} else {
    echo "Please provide a middleware name.\n";
}