<?php

namespace My\AutoLoader;

class AutoLoader {
    private $config;
    
    public function __construct(config $conf) {
        $this->config = $conf;
    }
    
    function autoload ($class){
        foreach ($this->config->my_include_paths as $path) {
            if (file_exists($path."/".$class.".php")){
                include_once $path."/".$class.".php"; 
                return TRUE;              
            }
        }
        return FALSE;
    }
}
