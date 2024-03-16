<?php

function autoload($className)
{
    //Building the path to the file
    $file = __DIR__ . '/' .  str_replace('\\', '/', $className) . '.php';

    //If the file exists, require it 
    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('autoload');
