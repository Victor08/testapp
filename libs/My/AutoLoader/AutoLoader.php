<?php

namespace My\AutoLoader;

class AutoLoader {
    private $include_paths;
    
    function __construct(config $conf) {
        $this->include_paths = $conf->get_include_paths();
    }
    
    public function autoload ($class) {
        $classname = str_replace ("\\" , '/' , $class) . ".php";
        $found = false;
        foreach ($this->include_paths as $path) {            
            if (file_exists($path."/".$classname)){
                include_once $path."/".$classname;
                $found = true;
                break;
            } else if (file_exists($path."/libs/".$classname)) {
                include_once $path."/libs/".$classname;
                $found = true;
                break;
            } 
        }
        if (!$found){
            if (file_exists($_SERVER['DOCUMENT_ROOT']."/../".$classname)) {
                include_once $_SERVER['DOCUMENT_ROOT']."/../".$classname;

            }
        }
    }
    
    
    
   
}
