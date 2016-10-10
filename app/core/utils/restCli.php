<?php

namespace utils;

class restCli extends \filters\filter {
    
    private $method;
    
    function __construct(){
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
    
    public function acceptMethod($method) {
        if(is_array($method)){
            if(!in_array($this->method, $method)){
                throw new \Exception("Método não aceito");
            }
        }else{
            $method = strtoupper($method);
            if($this->method != $method){
                throw new \Exception("Método não aceito");
            }
        }
    }
    
    public function output($param) {
        echo json_encode($param, JSON_NUMERIC_CHECK);
    }
    
    public function getParams() {
        switch($this->method){
            case 'POST': 
                return $this->getPostParameters();
        }
    }
    
    private function getPostParameters(){
        if(!empty($_POST)){
            return $_POST;
        }else{
            $input = file_get_contents('php://input');
            return (array) json_decode($input);
        }
    }
    
}

