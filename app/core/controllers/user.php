<?php

namespace controllers;

class user extends controller implements \interfaces\controller {

    private $model;
    private $api;

    function __construct() {
        $this->model = new \models\user();
        $this->api = new \utils\restCli();
    }

    public function init() {
        
    }

    public function logar() {

        $rs = array(
            'status' => false,
            'message' => '',
            'content' => null
        );

        try {
            $this->api->acceptMethod('post');

            $user = $this->api->getParams();

            $id = $this->model->login($user);

            if ($id) {
                $rs = array(
                    'status' => true
                );
            }else{
                $rs['message'] = 'Dados inválidos';
            }
        } catch (\Exception $ex) {
            $rs['message'] = $ex->getMessage();
        }

        $this->api->output($rs);
        exit;
    }

    public function check() {

        $rs = array(
            'status' => false,
            'message' => '',
            'content' => null
        );

        try {
            $this->api->acceptMethod('get');
            
            $rs['status'] = $this->model->check();

         
        } catch (\Exception $ex) {
            $rs['message'] = $ex->getMessage();
        }

        $this->api->output($rs);
        exit;
    }
    
     public function logout() {

        $rs = array(
            'status' => false,
            'message' => '',
            'content' => null
        );

        try {
            $this->api->acceptMethod('get');
            
            $rs['status'] = $this->model->logout();

         
        } catch (\Exception $ex) {
            $rs['message'] = $ex->getMessage();
        }

        $this->api->output($rs);
        exit;
    }
}
