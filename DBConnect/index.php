<?php
    namespace DBConnect;
    require $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
    // 594837.33
    //If you want the errors to be shown
    use \Config\DotEnv;
    // dd($_SERVER['DOCUMENT_ROOT']. '/.env');
    (new DotEnv($_SERVER['DOCUMENT_ROOT']. '/.env'))->load();
    // dd(getenv('APP_ENV'));    
    error_reporting(E_ALL); 
    ini_set('display_errors', '1');
    use Illuminate\Database\Capsule\Manager as Capsule;
    $capsule = new Capsule;
    
    $capsule->addConnection([
        "driver" => getenv('DATABASE_DRIVER') ? getenv('DATABASE_DRIVER') : 'mysql',
        "host" =>getenv('DATABASE_HOST') ? getenv('DATABASE_HOST') : '127.0.0.1',
        "database" => getenv('DATABASE_NAME') ? getenv('DATABASE_NAME') : 'dms_sample',
        "username" => getenv('DATABASE_USER') ? getenv('DATABASE_USER') : 'root',
        "password" => getenv('DATABASE_PASSWORD'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ],"awsapp");
    
    //Make this Capsule instance available globally.
    $capsule->setAsGlobal();
    // Setup the Eloquent ORM.
    $capsule->bootEloquent();
    // dd($capsule);
?>