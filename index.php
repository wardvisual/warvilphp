<?php

function bootstrap() {
    require_once 'app/init.php';
    new \app\core\App();
}

bootstrap();