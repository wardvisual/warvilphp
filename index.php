<?php

define('CURRENT_DIR', __DIR__);


function bootstrap()
{
    require_once 'app/init.php';
    new \app\core\App();
}

bootstrap();
