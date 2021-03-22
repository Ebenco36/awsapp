<?php
    namespace Documentation;   
    require("../vendor/autoload.php");
    $openapi = \OpenApi\scan($_SERVER['DOCUMENT_ROOT'].'/Controllers');
    // header('Content-Type: application/x-yaml');
    // echo $openapi->toYaml();
    header('Content-Type: application/json');
    echo $openapi->toJSON();