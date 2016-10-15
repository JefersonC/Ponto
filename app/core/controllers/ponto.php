<?php

namespace controllers;

class ponto extends controller implements \interfaces\controller {

    private $model;
    private $api;

    function __construct() {
        $this->model = new \models\ponto();
        $this->api = new \utils\restCli();
    }

    public function init() {
        exit;
    }

    public function pontos() {
        $rs = array(
            'status' => false,
            'message' => '',
            'content' => null
        );

        try {
            $this->api->acceptMethod('post');

            $param = $this->api->getParams();
            $date = null;
            if (!empty($param['date'])) {
                $date = $param['date'];
            }
            $pontos = $this->model->getPontos($date);

            $rs = array(
                'status' => true,
                'content' => $pontos
            );
        } catch (\Exception $ex) {
            $rs['stauts'] = false;
            $rs['message'] = $ex->getMessage();
        }

        $this->api->output($rs);
        exit;
    }

    public function indicadores() {
        $rs = array(
            'status' => false,
            'message' => '',
            'content' => null
        );

        try {
            $this->api->acceptMethod('get');

            $indicadores = $this->model->getIndicadores();


            $rs = array(
                'status' => true,
                'content' => $indicadores
            );
        } catch (\Exception $ex) {
            $rs = array(
                'status' => false,
                'message' => $ex->getMessage()
            );
        }

        $this->api->output($rs);
        exit;
    }

    public function fechar() {
         $rs = array(
            'status' => false,
            'message' => '',
            'content' => null
        );

        try {
            $this->api->acceptMethod('get');

            $rs['status'] = $this->model->fechar();
            
        } catch (\Exception $ex) {
            $rs = array(
                'status' => false,
                'message' => $ex->getMessage()
            );
        }

        $this->api->output($rs);
        exit;
    }
    
    public function abrir() {
         $rs = array(
            'status' => false,
            'message' => '',
            'content' => null
        );

        try {
            $this->api->acceptMethod('get');

            $rs['status'] = $this->model->abrir();
            
        } catch (\Exception $ex) {
            $rs = array(
                'status' => false,
                'message' => $ex->getMessage()
            );
        }

        $this->api->output($rs);
        exit;
    }
}
