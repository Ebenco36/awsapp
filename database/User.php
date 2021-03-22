<?php 

require "../DBConnect/index.php";
use Illuminate\Database\Capsule\Manager as Capsule;
try{
   Capsule::schema('awsapp')->create('users', function ($table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password');
      $table->timestamps();
   });
   
}catch(PDOException $e){
   echo $e->getMessage();
}

?>