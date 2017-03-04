<?php

class AutoLoad {
    static function load($class) {
        $file = './clases/' . $class . '.php';
        if(file_exists($file)){
            require_once $file;
        }
    }
}

spl_autoload_register('AutoLoad::load');