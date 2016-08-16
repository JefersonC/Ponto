<?php
namespace controllers;

class produtos extends controller{
    
    private $model;
            
    function __construct(){
        $this->model = new \models\model();
    }
    
    public function home(){

        
        if(isset($_GET['name'])){
            $this->model->setPessoa($_GET['name'], 'gorda');
        }
        
        $pessoa = $this->model->getPessoa();
        
        $nome = $pessoa['name'] . ' - ' . $pessoa['raca'];
        
        require DIR . 'views/index.phtml';
    }

    public function ver($id = null){
        if(isset($_GET['id'])){
            echo "VEr produto com id " . $_GET['id'];
        }else{
            echo "mim não ver id";
        }
    }
}
