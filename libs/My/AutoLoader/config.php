<?php
// setting
namespace My\AutoLoader;

class config {
    private $my_include_paths = array ();
    
    function __construct(array $paths) {
        $this->my_include_paths = $paths;
    }
    public function get_include_paths() {
        return $this->my_include_paths;
    }
}

