<?php

function generateService($serviceName)
{
    $serviceName = ucfirst($serviceName);
    $serviceContent = <<<EOT
<?php

namespace app\services;

class {$serviceName}Service
{
    /**
     * Create a new {$serviceName} service instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Constructor logic
    }
    
    /**
     * Main method for this service.
     *
     * @param array \$data
     * @return mixed
     */
    public function process(\$data = [])
    {
        // Service logic
        return \$data;
    }
}
EOT;

    // Create services directory if it doesn't exist
    if (!is_dir("app/services")) {
        mkdir("app/services", 0755, true);
    }

    file_put_contents("app/services/{$serviceName}Service.php", $serviceContent);

    echo "{$serviceName}Service.php has been created in the app/services directory.\n";
}

// Get the service name from the terminal argument
$serviceName = $argv[1] ?? '';

if ($serviceName) {
    generateService($serviceName);
} else {
    echo "Please provide a service name.\n";
}