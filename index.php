<?php
    require "./vendor/autoload.php";

    use Routes\Router;
    // dd($_SERVER);
    
    $routes = new Router();
    $routes->run();
    
    
