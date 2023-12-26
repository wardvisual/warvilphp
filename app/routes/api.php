<?php

use app\core\{RouterApi};


RouterApi::get('/', 'HomeController', 'index');
RouterApi::post('/store', 'HomeController', 'store');
RouterApi::get('/a', 'HomeController', function () {
    echo 'Hello world!';
});
