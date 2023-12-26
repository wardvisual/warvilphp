<?php

use app\core\{Router};


Router::get('/', 'HomeController', 'index');

Router::get('/h', null, function () {
    echo 'Hello world!';
});
