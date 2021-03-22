<?php
    namespace Controllers;
    class Controller{
        public static function CreateView($viewName){
            require_once("./Views/$viewName.php");
        }
    }