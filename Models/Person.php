<?php
    namespace Models;
    use Illuminate\Database\Eloquent\Model;
    class Person extends Model
    {
        protected $connection = "awsapp";
        protected $table="person";
    }
