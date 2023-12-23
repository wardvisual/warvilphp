<?php

namespace app\core;

class Layout
{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function render($layoutPath = null)
    {

        // Read warvil.json
        $jsonFile = file_get_contents('warvil.json');
        $warvilConfig = json_decode($jsonFile, true);

        $baseStyle = Config::get('paths/styles/base');

        if (file_exists($layoutPath)) {
            include_once $layoutPath;
        } else {
            // Handle the case when the layout file is not found
            echo 'Error: Layout file not found';
        }
    }
}
