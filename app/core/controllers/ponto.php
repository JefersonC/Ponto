<?php

namespace controllers;

class ponto extends controller implements \interfaces\controller {

    private $model;

    function __construct() {
        $this->model = new \models\ponto();
    }

    public function init() {
        $this->model->get();
        echo "Controller ponto";
        exit;
    }

    public function check() {
        $this->model->check();
    }

}
