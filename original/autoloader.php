<?php


require_once __DIR__ . "/vendor/autoload.php";

spl_autoload_register(function($class_name)
{
    $parts = explode('\\', $class_name);
    $namespace = array_shift($parts);
	
    if($namespace === 'Imod')
    {

		$class = str_replace('_', DIRECTORY_SEPARATOR, array_pop($parts));
        $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.ltrim(implode(DIRECTORY_SEPARATOR, $parts).DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR).$class.'.php';


        if(is_file($path) === true){
            
            require_once $path;
        }
    }
});

