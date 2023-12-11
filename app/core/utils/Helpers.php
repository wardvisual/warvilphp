<?php

function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function cleaner($string)
{
    return ucfirst(preg_replace('/_/', ' ', $string));
}

function assets($string)
{
    $path = "/public/assets/" . $string;

    echo $path;
}

function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function alert($data)
{
    echo '<script>alert(JSON.stringify(' . json_encode($data) . '));</script>';
}

function console_log($data)
{
    echo '<script>console.log(' . json_encode($data) . ');</script>';
}
