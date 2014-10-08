<?php
// setting
namespace My\AutoLoader;

class config {
    private $my_include_paths = array ();
    public function __construct(array $paths) {
        $this->my_include_paths = $paths;
    }
}

