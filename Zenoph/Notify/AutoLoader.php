<?php
    
    class Notify_AutoLoader{
        public function __construct() {
            if (function_exists('__autoload')) {
                //    Register any existing autoloader function with SPL, so we don't get any clashes
                spl_autoload_register('__autoload');
            }
            spl_autoload_register(array($this, 'NotifyClassLoader'));
        }
        
        public function NotifyClassLoader($className){
            $classFile = __DIR__.'/../../'.str_replace('\\', '/', $className).'.php';
            
            if (file_exists($classFile))
                include_once ($classFile);
        }
    }
    
    $loader = new Notify_AutoLoader();