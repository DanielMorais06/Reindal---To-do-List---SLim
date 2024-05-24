<?php

namespace App\Controllers;

class Controller {

    protected $container;
    
    public function __construct($container){
        try{
        $this->container = $container;
        }catch (\Exception $e) {
            $this->container->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }
}