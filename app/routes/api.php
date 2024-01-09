<?php

use app\core\{RouterApi};


RouterApi::get('/', 'HomeController', 'index');
RouterApi::post('/store', 'HomeController', 'store');
RouterApi::get('/a', 'HomeController', function () {
    app\core\Response::json(["success" => false, 'message' => 'hello']);
});
