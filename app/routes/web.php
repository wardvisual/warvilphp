<?php

use app\core\{Router};


Router::get('/', 'Home', 'index');

Router::get('/h', null, function () {
    echo 'Hello world!';
});
