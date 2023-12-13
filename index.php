<?php
// Autoloader function
spl_autoload_register(function ($className) {
    // Exclude certain classes from autoloading
    // $excludedClasses = ['Memcached'];
    // print_r(explode('\'), $className);
    // if (in_array(explode('/', $className), $excludedClasses)) {
    //     return;
    // }
    $className = str_replace('\\', '/', $className);
    $classPath = __DIR__ . '/app/' . $className . '.php';
  
    if (file_exists($classPath)) {
        require_once $classPath;
    }
});

define('APP_PATH', __DIR__ . '/app/');
require_once 'core/App.php';
require_once 'core/Router.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';
require_once 'core/Cache.php';
require_once 'app/config/database.php';

$app = new App();
