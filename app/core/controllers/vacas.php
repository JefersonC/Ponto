<?php
namespace controllers;

class vacas extends controller implements \interfaces\controller{
 
    public function init(){
        echo "Controller index";
        exit;
    }
    
    public function ver(){
        $id = $_GET['cod'];
    }

}
