# WarvilPHP Framework

A **lightweight PHP framework** inspired by Laravel, designed for developers who appreciate simplicity and direct access to the PHP language.

![WarvilPHP](https://raw.githubusercontent.com/wardvisual/warvilphp/refs/heads/main/public/assets/warvilphp.jpg)

<p align="center">
  <img src="https://img.shields.io/badge/PHP-v8.0+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
  <img src="https://img.shields.io/badge/Status-Alpha-red.svg" alt="Status">
  <img src="https://img.shields.io/badge/API-Unstable-orange.svg" alt="API Stability">
</p>

## 📋 Table of Contents

- [Introduction](#-introduction)
- [Project Status](#-project-status)
- [Roadmap to Production Readiness](#-roadmap-to-production-readiness)
- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Directory Structure](#-directory-structure)
- [Configuration](#-configuration)
- [Environment Variables](#-environment-variables)
- [Command Line Interface](#-command-line-interface)
- [Routing System](#-routing-system)
- [Controllers](#-controllers)
- [Views](#-views)
- [Models](#-models)
- [Components](#-components)
- [Middleware](#-middleware)
- [Database Migrations](#-database-migrations)
- [API Development](#-api-development)
- [File Storage](#-file-storage)
- [Contributing](#-contributing)
- [License](#-license)

## 🌟 Introduction
WarvilPHP is a lightweight MVC framework for PHP applications. It provides a clean and elegant syntax similar to Laravel but with a smaller footprint and more direct access to PHP. The framework helps you build web applications quickly without the complexity of larger frameworks.

### The Story Behind WarvilPHP

WarvilPHP was born out of necessity and a passion for efficient development. While working on numerous PHP projects, I found myself repeatedly recreating the same foundational structure - routing systems, database abstractions, and templating logic. This repetition felt inefficient, yet I wasn't satisfied with the complexity and overhead of existing frameworks.

I wanted something that maintained the directness and flexibility of pure PHP while providing the structure and convenience of a framework. Something that would embrace PHP's strengths rather than hide them behind layers of abstraction.

After refining this structure across multiple projects, I realized that this middle-ground approach could benefit other developers who shared my appreciation for PHP's simplicity. WarvilPHP represents that balance - a framework that provides helpful structure and tools without getting in your way or forcing you into restrictive patterns.

This framework is now open source, I'm open-sourcing WarvilPHP to help developers who want to build PHP applications with a clean architecture but without sacrificing the power and directness that made us fall in love with PHP in the first place.


## 🚦 Project Status

> **⚠️ Development Status: Pre-release**
> 
> WarvilPHP is currently in **pre-release development stage**. While the framework includes many functional features, it is not yet recommended for production environments or critical applications.
> 
> Following semantic versioning standards:
> - Current releases (v0.x.x) are considered development/alpha versions
> - Future v1.0.0 will mark the first stable, production-ready release
>
> We encourage developers to explore WarvilPHP for personal projects, learning purposes, or non-critical applications. Your feedback during this phase is invaluable to the project's growth!

## 🗺️ Roadmap to Production Readiness

We're following semantic versioning (semver.org) with a clear path to a stable v1.0.0 release:

- [x] **v0.1.0-alpha** (Current)
  - Initial framework architecture
  - Basic MVC implementation
  - Routing system for web and API
  - Command line interface
  - Development server via `php warvil serve`
  - View templating and components

- [ ] **v0.2.0-alpha**
  - Enhanced database ORM functionality
  - Improved middleware system
  - Extended validation capabilities
  - File storage improvements
  - Authentication scaffolding

- [ ] **v0.5.0-beta**
  - Complete test coverage for core components
  - Performance optimization
  - Security hardening
  - Comprehensive error handling
  - Extended documentation with examples

- [ ] **v0.9.0-rc** (Release Candidate)
  - Feature-complete implementation
  - Production deployment guides
  - API stabilization
  - Backward compatibility guarantees

- [ ] **v1.0.0** (Stable Release)
  - Production-ready code
  - Complete documentation
  - Long-term support plan
  - Community-tested in various environments

After v1.0.0, we will strictly follow semantic versioning:
- MAJOR version for incompatible API changes (v2.0.0)
- MINOR version for backwards-compatible functionality (v1.1.0)
- PATCH version for backwards-compatible bug fixes (v1.0.1)

We welcome contributors to help us reach these milestones faster! See our [Contributing](#-contributing) section for details on how to get involved.

## ✨ Features

- **🏗️ MVC Architecture**: Clean separation of Model, View and Controller
- **🌐 Routing System**: Simple and intuitive routing for both web and API endpoints
- **🗄️ Database ORM**: Lightweight database abstraction and query building
- **🔧 CLI Commands**: Built-in command line tools for scaffolding
- **🧩 Component-based Views**: Reusable view components
- **🛡️ Middleware Support**: Request filtering capabilities
- **🔁 API Response Handling**: Tools for building RESTful APIs
- **🔐 Environment Variables**: Secure configuration management
- **📁 File Storage**: Simple file storage management

## 🛠️ Requirements

- PHP 8.0 or higher
- Composer
- MySQL Database
- PDO PHP Extension
- JSON PHP Extension
- FileInfo PHP Extension

## 🚀 Installation

### Option 1: Via Composer Create-Project

```bash
composer create-project wardvisual/warvilphp your-project-name
cd your-project-name
composer serve
```

## 📂 Directory Structure

```text
warvilphp/
├── app/                  # Application code
│   ├── controllers/      # Controllers
│   ├── core/             # Framework core files
│   │   ├── utils/        # Framework utilities
│   ├── database/         # Database files
│   │   ├── sql/          # SQL migrations
│   │   ├── factories/    # Model factories
│   ├── middlewares/      # Middlewares
│   ├── models/           # Models
│   ├── routes/           # Route definitions
│   ├── services/         # Service classes
│   ├── shared/           # Shared components
│   │   ├── components/   # View components
│   │   ├── layouts/      # View layouts
│   │   ├── errors/       # Error pages
│   ├── traits/           # PHP traits
│   ├── views/            # Views
│   ├── [bootstrap.php]   # Application bootstrap
│   └── [init.php]        # Manual initialization
├── bin/                  # Binary/executable files
│   ├── install           # Installation script
│   ├── warvil            # CLI command runner
│   └── [warvil.bat]      # Windows CLI command runner
├── cli/                  # CLI command definitions
├── public/               # Publicly accessible files
│   ├── assets/           # Assets (images, fonts)
│   ├── js/               # JavaScript files
│   ├── styles/           # CSS files
│   └── uploads/          # Uploaded files
├── vendor/               # Composer packages
├── .env                  # Environment variables
├── [.env.example]        # Environment example
├── .gitignore            # Git ignored files
├── .htaccess             # Apache configuration
├── [composer.json]       # Composer configuration
├── [index.php]           # Application entry point
└── [warvil.json]         # Framework configuration
```

## ⚙️ Configuration
WarvilPHP uses a JSON configuration file (warvil.json) for application settings
```json
  "name": "warvilphp",
  "version": "1.0.0",
  "description": "WarvilPHP, A lightweight PHP framework",
  "author": "Wardvisual <wardvisual@gmail.com>",
  "keywords": ["php", "framework", "warvilPHP"],
  "database": {
    "driver": "mysql",
    "host": "localhost",
    "dbname": "your_database",
    "username": "root",
    "password": ""
  },
  "paths": {
    "public": "public",
    "controllers": "app/controllers",
    "models": "app/models",
    "views": "app/views"
  }
}
```
## 🔐 Environment Variables
Sensitive configuration like database credentials should be stored in the .env file:

```.env
APP_NAME=WarvilPHP
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_KEY=base64:your-random-key-here

DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=warvilphp
DB_USERNAME=root
DB_PASSWORD=

STORAGE_DIRECTORY=/public/uploads
STORAGE_MAX_SIZE=1000000
```

Generate a secure application key:
```sh
php warvil key:generate
```

## 🖥️ Command Line Interface
WarvilPHP comes with a command-line tool called warvil for scaffolding components:

#### Development
```sh
# Start development server
php warvil serve
# OR with custom host and port
php warvil serve localhost 3000

# Show help
php warvil help
```
#### Generator Commands
```sh
# Create a controller
php warvil make:controller UserController

# Create a model
php warvil make:model User

# Create a view
php warvil make:view users/index

# Create a middleware
php warvil make:middleware Auth

# Create a component
php warvil make:component buttons/primary

# Create a service
php warvil make:service UserService

# Create an API controller
php warvil make:api ProductController

# Create a layout
php warvil make:layout admin

# Create a database table schema
php warvil make:table Users

```
#### Database Commands
```sh
php warvil migration:run User:up
```

#### Utility Commands
```sh
# Generate an application key
php warvil key:generate
```

## 🌐 Routing System
WarvilPHP has two types of routes: web routes and API routes.

Web Routes (app/routes/web.php)
```php
use app\core\Router;

// Simple route with controller and method
Router::get('/', 'Home', 'index');

// Route with callback function
Router::get('/about', null, function() {
    echo 'About page';
});

// Route with POST method
Router::post('/contact', 'Contact', 'submit');
```

API Routes (app/routes/api.php)

```php
use app\core\RouterApi;

// API routes are automatically prefixed with /api
RouterApi::get('/', 'HomeController', 'index');
RouterApi::post('/users', 'UserController', 'store');
```


## 🎮 Controllers
Controllers handle request logic and return responses:
```php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $users = (new User())->all();
        $this->view('users/index', ['users' => $users]);
    }

    public function store(): void
    {
        $data = Request::validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
        ]);
        
        $user = new User();
        $user->create($data);
        
        Response::json([
            'success' => true,
            'message' => 'User created successfully'
        ]);
    }
}
```


## 👁️ Views
Views are PHP files that contain HTML with embedded PHP code:
```php
<!-- app/views/users/index.php -->
<div class="container">
    <h1>Users</h1>
    
    <div class="user-list">
        <?php foreach($users as $user): ?>
            <div class="user-card">
                <h3><?= $user['name'] ?></h3>
                <p><?= $user['email'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
```

Layouts
Layouts provide a template for your views:

```php
<!-- app/shared/layouts/main.php -->
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($warvilConfig['name']) ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= htmlspecialchars($baseStyle) ?>">
    <?php echo $cssPath ? '<link rel="stylesheet" href="' . htmlspecialchars($cssPath) . '">' : ''; ?>
</head>
<body>
    <header>
        <!-- Header content -->
    </header>
    
    <main>
        <?= $this->content ?>
    </main>
    
    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
```



## 🗄️ Models
Models represent database tables and handle data operations:
```php
namespace app\models;

use app\core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }
    
    public function findByEmail($email)
    {
        return $this->getByField('email', $email);
    }
}
```

Using models:
```php
$user = new User();

// Create
$user->create([
    'username' => 'john_doe',
    'email' => 'john@example.com'
]);

// Read all records
$allUsers = $user->all();

// Find by ID
$singleUser = $user->getById(1);

// Update
$user->update(1, [
    'username' => 'jane_doe'
]);

// Delete
$user->delete(1);
```



## 🧩 Components
Components are reusable view partials:

```php
// app/shared/components/card/index.php
function Card($data, $onclick)
{
    ?>
    <div class="card">
        <h3><?= $data['title'] ?></h3>
        <p><?= $data['content'] ?></p>
        <button onclick="<?= $onclick ?>(<?= $data['id'] ?>)">
            <?= $data['buttonText'] ?>
        </button>
    </div>
    <?php
}
```


Using components in views:
```php
<!-- In a view file -->
<?php Card([
    'id' => 1,
    'title' => 'Example Card',
    'content' => 'This is the content of the card',
    'buttonText' => 'Click me'
], 'handleClick'); ?>
```


## 🛡️ Middleware
Middleware filters HTTP requests:

```php
namespace app\middlewares;

use app\core\Request;
use app\core\Response;

class Auth
{
    public function handle(Request $request, $next)
    {
        // Check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            return Response::json(['error' => 'Unauthorized'], 401);
        }
        
        // Continue to next middleware or controller
        return $next($request);
    }
}
```


## 🔄 Database Migrations
Create and manage database tables:

```php
// app/database/sql/User.php
use app\core\Model;

require_once 'app/init.php';

class User extends Model
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->down();
        $fields = [
            'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
            'username' => 'VARCHAR(255)',
            'email' => 'VARCHAR(255)',
            'password' => 'VARCHAR(255)',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];

        $this->createTable('users', $fields);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
```

Using components in views:
```sh
php warvil migration:run User:up
```

## 🔌 API Development
WarvilPHP provides tools for easy API development:

```php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $users = (new User())->all();
        Response::json(['data' => $users]);
    }
    
    public function store(): void
    {
        try {
            $data = Request::validate([
                'username' => 'required|min:3',
                'email' => 'required|email',
            ]);
            
            $user = new User();
            $user->create($data);
            
            Response::json([
                'success' => true,
                'message' => 'User created successfully'
            ], 201);
        } catch (\Exception $e) {
            Response::status(400)->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

```




## 📁 File Storage
Handle file uploads:
```php
use app\core\Storage;

// In a controller method
public function uploadProfilePicture(): void
{
    $file = $_FILES['profile_picture'];
    $uploadPath = Storage::upload($file);
    
    if ($uploadPath) {
        Response::json([
            'success' => true,
            'path' => $uploadPath
        ]);
    } else {
        Response::status(400)->json([
            'success' => false,
            'message' => 'Upload failed'
        ]);
    }
}

```

Configure storage in `.env` and `warvil.json`:
```env
STORAGE_DIRECTORY=/public/uploads
STORAGE_MAX_SIZE=1000000
```
```json
"storage": {
  "directory": "/public/uploads",
  "max_size": 1000000,
  "allowed_types": ["jpg", "jpeg", "png", "gif"]
}
```


## 🤝 Contributing
Contributions are welcome! Please feel free to submit a Pull Request

1. Fork the Project
2. Create your Feature Branch (git checkout -b feature/amazing-feature)
3. Commit your Changes (git commit -m 'Add some amazing feature')
4. Push to the Branch (git push origin feature/amazing-feature)
5. Open a Pull Request

## 📄 License
WarvilPHP is open-sourced software licensed under the MIT license.


<p align="center">
  <small>WarvilPHP is under active development. While we strive for stability, use in production is at your own risk.</small>
</p>
<p align="center"> Made with ❤️ by <a href="https://github.com/wardvisual">WardVisual</a> </p>