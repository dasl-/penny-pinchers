<?php

/**
 * Autoloads our classes
 * @param  string $class
 */
function autoload($class) {
    $class = preg_replace('/^(Finder)(_.+)/', "Model$2", $class);
    $class = str_replace('_', '/', $class) . '.php';
    require_once($class);
}

spl_autoload_register('autoload');
