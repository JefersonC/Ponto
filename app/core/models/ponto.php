<?php

namespace models;

class ponto extends model implements \interfaces\model {

    public function get() {
        $this->setTable('ponto');

        $s = array('estado', 'id');

        $rs = $this->select($s)->exec('ALL');

        return $rs;
    }

    public function check() {
//        $input = file_get_contents('php://input');
//        $request = json_decode($input);
        $request = new \stdClass();

        $request->idUser = 1;

        $apontamentos = $this->getApontamentosAbertos($request->idUser);
    }

    private function getApontamentosAbertos($idUser) {
        $this->setTable('ponto');

        $s = array('id');

        $w = array(
            'estado = ?' => 1,
            'idUsuario = ?' => $idUser
        );

        $rs = $this->select($s)->where($w)->exec('ALL');

        if ($rs) {
            debug($rs);
        } else {
            debug($this->getError());
        }

        return $rs;
    }

}
