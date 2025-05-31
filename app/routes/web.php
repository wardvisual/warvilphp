<?php

use app\core\{Router};


Router::get('/', 'HomeController', 'index');
// Home routes
Router::get('/home', 'HomeController', 'index');
Router::get('/home/create', 'HomeController', 'create');
Router::post('/home/store', 'HomeController', 'store');
Router::get('/home/show', 'HomeController', 'show');
Router::get('/home/edit', 'HomeController', 'edit');
Router::post('/home/update', 'HomeController', 'update');
Router::post('/home/destroy', 'HomeController', 'destroy');
