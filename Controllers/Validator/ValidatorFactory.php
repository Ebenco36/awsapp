<?php
namespace Controllers\Validator;

use Illuminate\Validation;
use Illuminate\Filesystem;
use Illuminate\Translation;
use Illuminate\Validation\Validator;
class ValidatorFactory
{
    
    public static function Validator($all, array $rules, array $messages){
        $filesystem = new Filesystem\Filesystem();
        $fileLoader = new Translation\FileLoader($filesystem, '');
        $translator = new Translation\Translator($fileLoader, 'en_US');
        $factory = new Validation\Factory($translator);

        $validator = $factory->make($all, $rules, $messages);
        return $validator;
    }
    
}